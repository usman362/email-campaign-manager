<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('gmail')) {
    function gmail($key) {
        return Auth::user()->{$key};
    }
}


