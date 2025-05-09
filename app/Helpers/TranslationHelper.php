<?php

namespace App\Helpers;

class TranslationHelper
{
    public static function prepareTranslationData($request)
    {

        $nameData = $request->input("name", '');
        $codeData = $request->input("code", '');
        $translationData = [
            'name' => $nameData,
            'code' => $codeData,
            'status' => $request->status === 'on' ? 1 : 0,
        ];
        return $translationData;
    }
}
