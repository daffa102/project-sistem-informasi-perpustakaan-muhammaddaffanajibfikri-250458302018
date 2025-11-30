<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Fine;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create payment and get Snap token
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'fine_id' => 'required|exists:fines,id',
        ]);

        $fine = Fine::with('borrowing.member', 'borrowing.book')->findOrFail($request->fine_id);
        
        // Check if fine is already paid
        if ($fine->paid) {
            return response()->json(['error' => 'Fine already paid'], 400);
        }

        $memberId = auth()->user()->member->id;
        
        // Generate unique order ID
        $orderId = 'FINE-' . $fine->id . '-' . time();

        // Create payment record
        $payment = Payment::create([
            'fine_id' => $fine->id,
            'member_id' => $memberId,
            'order_id' => $orderId,
            'amount' => $fine->amount,
            'transaction_status' => 'pending',
        ]);

        // Prepare transaction details for Midtrans
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => (int) $fine->amount,
        ];

        $itemDetails = [
            [
                'id' => 'fine-' . $fine->id,
                'price' => (int) $fine->amount,
                'quantity' => 1,
                'name' => 'Denda Keterlambatan - ' . ($fine->borrowing->book->title ?? 'Buku'),
            ],
        ];

        $customerDetails = [
            'first_name' => $fine->borrowing->member->name ?? 'Member',
            'email' => auth()->user()->email,
            'phone' => $fine->borrowing->member->phone ?? '08123456789',
        ];

        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
            'callbacks' => [
                'finish' => route('member.fines.payment'),
            ],
        ];

        try {
            // Get Snap token from Midtrans with SSL bypass for development
            if (!config('midtrans.is_production')) {
                $snapToken = $this->getSnapTokenWithSSLBypass($transactionData);
            } else {
                $snapToken = Snap::getSnapToken($transactionData);
            }
            
            // Save snap token
            $payment->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get Snap token with SSL verification disabled (for development only)
     */
    private function getSnapTokenWithSSLBypass($params)
    {
        $serverKey = config('midtrans.server_key');
        $url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        
        // Debug: Log server key (first 10 chars only for security)
        \Log::info('Midtrans Server Key (partial): ' . substr($serverKey, 0, 15) . '...');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($serverKey . ':')
        ]);
        
        // Disable SSL verification for development
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception('CURL Error: ' . $error);
        }
        
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        // Debug: Log response
        \Log::info('Midtrans Response:', ['code' => $httpCode, 'response' => $result]);
        
        if ($httpCode !== 201 && $httpCode !== 200) {
            $errorMessage = $result['error_messages'][0] ?? 'Failed to get snap token';
            throw new \Exception($errorMessage . ' (HTTP ' . $httpCode . ')');
        }
        
        return $result['token'];
    }

    /**
     * Handle Midtrans callback/notification
     */
    public function callback(Request $request)
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status ?? null;

            // Find payment
            $payment = Payment::where('order_id', $orderId)->firstOrFail();

            // Verify signature
            $signatureKey = hash('sha512', 
                $orderId . $notification->status_code . $notification->gross_amount . config('midtrans.server_key')
            );

            if ($signatureKey !== $notification->signature_key) {
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Update payment based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->updatePaymentSuccess($payment, $notification);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->updatePaymentSuccess($payment, $notification);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $payment->update([
                    'transaction_status' => $transactionStatus,
                    'midtrans_response' => $notification->getResponse(),
                ]);
            } elseif ($transactionStatus == 'pending') {
                $payment->update([
                    'transaction_status' => 'pending',
                    'transaction_id' => $notification->transaction_id,
                    'payment_type' => $notification->payment_type,
                    'midtrans_response' => $notification->getResponse(),
                ]);
            }

            return response()->json(['message' => 'Callback processed']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update payment and fine status on success
     */
    private function updatePaymentSuccess($payment, $notification)
    {
        $payment->update([
            'transaction_status' => 'settlement',
            'transaction_id' => $notification->transaction_id,
            'payment_type' => $notification->payment_type,
            'paid_at' => now(),
            'midtrans_response' => $notification->getResponse(),
        ]);

        // Update fine status
        $fine = $payment->fine;
        $fine->update(['paid' => true]);
    }

    /**
     * Payment finish page - Auto check status from Midtrans
     */
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if (!$orderId) {
            return redirect()->route('member.fines.payment')
                ->with('error', 'Order ID not found');
        }

        $payment = Payment::where('order_id', $orderId)->first();
        
        if (!$payment) {
            return redirect()->route('member.fines.payment')
                ->with('error', 'Payment not found');
        }

        // 🔥 AUTO-CHECK: Query status dari Midtrans API
        try {
            $status = \Midtrans\Transaction::status($orderId);
            
            // Update payment based on actual status from Midtrans
            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                // Payment success - update database
                $payment->update([
                    'transaction_status' => 'settlement',
                    'transaction_id' => $status->transaction_id,
                    'payment_type' => $status->payment_type,
                    'paid_at' => now(),
                    'midtrans_response' => json_encode($status),
                ]);

                // Update fine status
                $fine = $payment->fine;
                if ($fine && !$fine->paid) {
                    $fine->update(['paid' => true]);
                }
                
                return view('payment.finish', [
                    'payment' => $payment->fresh(),
                    'status' => 'success',
                    'message' => 'Pembayaran berhasil! Denda telah lunas.'
                ]);
                
            } elseif ($status->transaction_status == 'pending') {
                // Still pending
                $payment->update([
                    'transaction_status' => 'pending',
                    'transaction_id' => $status->transaction_id ?? null,
                    'payment_type' => $status->payment_type ?? null,
                    'midtrans_response' => json_encode($status),
                ]);
                
                return view('payment.finish', [
                    'payment' => $payment->fresh(),
                    'status' => 'pending',
                    'message' => 'Pembayaran masih diproses. Silakan tunggu beberapa saat.'
                ]);
                
            } else {
                // Failed/cancelled
                $payment->update([
                    'transaction_status' => $status->transaction_status,
                    'midtrans_response' => json_encode($status),
                ]);
                
                return view('payment.finish', [
                    'payment' => $payment->fresh(),
                    'status' => 'failed',
                    'message' => 'Pembayaran gagal atau dibatalkan.'
                ]);
            }
            
        } catch (\Exception $e) {
            // Jika gagal cek status (misal: network error), tetap tampilkan halaman
            \Log::error('Failed to check payment status: ' . $e->getMessage());
            
            return view('payment.finish', [
                'payment' => $payment,
                'status' => 'unknown',
                'message' => 'Tidak dapat memverifikasi status pembayaran. Silakan cek kembali nanti.'
            ]);
        }
    }

    /**
     * Payment unfinish page
     */
    public function unfinish(Request $request)
    {
        return view('payment.unfinish');
    }

    /**
     * Payment error page
     */
    public function error(Request $request)
    {
        return view('payment.error');
    }
}
