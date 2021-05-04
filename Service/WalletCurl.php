<?php

namespace Service;

class WalletCurl
{
    /**
     * Http Request
     * @param string $endPoint
     * @return bool
     */
    public static function Request(string $endPoint = '') : bool
    {
        $ch = curl_init($endPoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        return curl_error($ch);
    }
}