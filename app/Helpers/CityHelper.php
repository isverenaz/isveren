<?php

namespace App\Helpers;

use App\Models\Translation;

class CityHelper
{
    public static function prepareCityData($request)
    {
        $nameData = [];
        $locales = Translation::where('status',1)->get();

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : '';
            $nameData[$code] = $request->input("name.$code", '');
        }

        $cityData = [
            'name' => $nameData,
            'status' => $request->status === 'on' ? 1 : 0,
        ];

        return $cityData;
    }
}
