<?php

namespace App\Services;

class PasswordGenerator
{
    public static function generate(int $length = 8, bool $includeSymbols = true): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $symbols = '!@#$%^&*()-_=+[]{}<>?';

        $characters .= $includeSymbols ? $symbols : '';

        $password = '';
        $maxIndex = strlen($characters) - 1;

        for($x = 0; $x < $length; $x++) {
            $password .= $characters[mt_rand(0, $maxIndex)];
        }

        return $password;
    }
}
