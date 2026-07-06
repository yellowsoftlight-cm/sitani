<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | Ini menentukan driver broadcasting default yang dipakai aplikasi saat
    | memancarkan event (mis. NotifikasiDibuat, PesanChatDikirim). Nilainya
    | diambil dari BROADCAST_CONNECTION pada .env — gunakan "pusher" untuk
    | broadcasting real-time sungguhan, atau "log" saat development tanpa
    | akun Pusher (event hanya dicatat ke storage/logs, tidak benar-benar
    | dikirim ke browser).
    |
    */

    'default' => env('BROADCAST_CONNECTION', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'host' => env('PUSHER_HOST', 'api-'.env('PUSHER_APP_CLUSTER', 'ap1').'.pusher.com'),
                'port' => env('PUSHER_PORT', 443),
                'scheme' => env('PUSHER_SCHEME', 'https'),
                'encrypted' => true,
                'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
            ],
            'client_options' => [
                // Opsi tambahan untuk Guzzle HTTP client Pusher bisa ditaruh di sini.
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
