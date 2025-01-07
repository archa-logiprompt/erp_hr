<?php

use Illuminate\Support\Facades\Auth;

return [
    'api' => 'http://logierp.projectlogi.club/public/api/',
    'user_id' => Auth::check() ? Auth::id() : null,
];
