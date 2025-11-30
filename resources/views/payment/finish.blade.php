@extends('layouts.appmember')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <!-- Success Card -->
        @if($status === 'success')
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h1>
            <p class="text-gray-600 mb-6">{{ $message }}</p>
            
            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order ID:</span>
                    <span class="font-mono text-sm font-semibold">{{ $payment->order_id }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Jumlah:</span>
                    <span class="font-bold text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Lunas</span>
                </div>
            </div>
            
            <a href="{{ route('member.fines.payment') }}" wire:navigate
               class="block w-full bg-gradient-to-r from-blue-600 to-teal-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">
                Kembali ke Dashboard
            </a>
        </div>
        
        <!-- Pending Card -->
        @elseif($status === 'pending')
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Menunggu Pembayaran</h1>
            <p class="text-gray-600 mb-6">{{ $message }}</p>
            
            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order ID:</span>
                    <span class="font-mono text-sm font-semibold">{{ $payment->order_id }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Jumlah:</span>
                    <span class="font-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Pending</span>
                </div>
            </div>
            
            <a href="{{ route('member.fines.payment') }}" wire:navigate
               class="block w-full bg-gradient-to-r from-blue-600 to-teal-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">
                Kembali ke Dashboard
            </a>
        </div>
        
        <!-- Failed Card -->
        @elseif($status === 'failed')
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pembayaran Gagal</h1>
            <p class="text-gray-600 mb-6">{{ $message }}</p>
            
            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order ID:</span>
                    <span class="font-mono text-sm font-semibold">{{ $payment->order_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Gagal</span>
                </div>
            </div>
            
            <a href="{{ route('member.fines.payment') }}" wire:navigate
               class="block w-full bg-gradient-to-r from-blue-600 to-teal-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition mb-3">
                Coba Lagi
            </a>
            <a href="{{ route('member.dashboard') }}" wire:navigate
               class="block w-full border-2 border-gray-300 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-50 transition">
                Kembali ke Dashboard
            </a>
        </div>
        
        <!-- Unknown/Error Card -->
        @else
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Status Tidak Diketahui</h1>
            <p class="text-gray-600 mb-6">{{ $message }}</p>
            
            @if($payment)
            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order ID:</span>
                    <span class="font-mono text-sm font-semibold">{{ $payment->order_id }}</span>
                </div>
            </div>
            @endif
            
            <a href="{{ route('member.fines.payment') }}" wire:navigate
               class="block w-full bg-gradient-to-r from-blue-600 to-teal-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">
                Kembali ke Dashboard
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
