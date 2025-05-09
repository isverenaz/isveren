<?php

namespace App\Helpers;

use App\Models\Translation;

class CategoryHelper
{
    public static function prepareCategoryData($request)
    {
        $locales = Translation::where('status',1)->get();
        $nameData = [];


        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : '';
            $nameData[$code] = $request->input("name.".$code, '');
        }
        $parent_id = $request->input('parent_id');

        $categoryData = [
            'name' => $nameData,
            'parent_id' => is_null($parent_id) ? null : $parent_id,
            'status' => $request->status === 'on' ? 1 : 0,
        ];

        return $categoryData;
    }
}
