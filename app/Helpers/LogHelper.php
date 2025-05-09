<?php

namespace App\Helpers;

use App\Models\Log;

class LogHelper
{

    public static function user_company_log($data)
    {
        $log = false;
        if (!empty($data['user_id']))
        {
           $log = Log::create($data);
        }

        return $log;
    }


    public static function admin_log($data)
    {
        $log = false;
        if (!empty($data['user_id']))
        {
            $log = Log::create($data);
        }
        return $log;
    }
}
