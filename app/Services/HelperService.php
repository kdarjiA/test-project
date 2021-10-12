<?php

namespace App\Services;

class HelperService
{
    public function __construct()
    {
    }

    public static function getJsonDataFromUploadedFile($name, $key_value = false)
    {
        $json = \File::get(public_path("uploads/" . $name));
        if (!self::checkIfValidJson($json)) {
            return false;
        }
        $json_data = json_decode($json, true);
        if (!empty($json_data)) {
            if ($key_value) {
                $return_data = [];
                $i           = 0;
                foreach ($json_data as $key => $value) {
                    $return_data[ $i ][] = $key;
                    $return_data[ $i ][] = $value;
                    $i++;
                }
                return $return_data;
            }
            return $json_data;
        }
        return [];
    }

    public static function checkIfValidJson($content)
    {
        // Attempt to decode payload
        json_decode($content);
        if (json_last_error() != JSON_ERROR_NONE) {
            return false;
        }
        return true;
    }
}
