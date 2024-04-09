<?php

// config for BeraniDigital/LibraryLaravelLogtoIo
return [
    'endpoint' => env('LOG_TO_ENDPOINT'),
    'app_id' => env('LOG_TO_APP_ID'),
    'app_secret' => env('LOG_TO_APP_SECRET'),
    'lee_way' => env('LOG_TO_LEE_WAY', 15)
];
