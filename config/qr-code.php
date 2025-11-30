<?php

return [
    /*
    |--------------------------------------------------------------------------
    | QR Code Backend
    |--------------------------------------------------------------------------
    |
    | Pilih backend untuk generate QR Code. Opsi: 'gd' atau 'imagick'.
    | Karena imagick belum aktif, kita pakai gd.
    |
    */

    'default' => 'gd',

    'gd' => [
        'driver' => 'gd',
    ],

    'imagick' => [
        'driver' => 'imagick',
    ],
];
