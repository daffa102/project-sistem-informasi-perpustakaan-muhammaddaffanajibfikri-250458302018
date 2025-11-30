 <?php
  public function store(Request $request)
    {
        $request->validate([
            'participant_name' => 'required|string|max:255',
            'course_name' => 'required|string|max:255',
        ]);

        $certificate = Certificate::create([
            'participant_name' => $request->participant_name,
            'course_name' => $request->course_name,
        ]);

        $qrCodePath = 'qrcodes/' . $certificate->id . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);

        // Cek apakah folder qrcodes sudah ada, jika belum buat folder tersebut
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        QrCode::format('png')->size(200)->generate(route('certificates.verify', $certificate->id), $fullPath);

        $certificate->update(['qr_code_path' => $qrCodePath]);

        return redirect()->route('book.dashboard')->with('success', 'Sertifikat berhasil dibuat dengan QR Code!');
    }
