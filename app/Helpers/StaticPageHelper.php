<?php

namespace App\Helpers;

use App\Models\Translation;

class StaticPageHelper
{
    public static function prepareStaticData($request)
    {

        $titleData = [];
        $descriptionData = [];
        $locales = Translation::where('status',1)->get();

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : '';
            $titleData[$code] = $request->input("title.$code", '');
            $descriptionData[$code] = $request->input("description.$code", '');
        }

        if($request->hasFile('logo')){
            $imageName = time().'.'.$request->logo->extension();
            $image = $request->logo->move(public_path('uploads/static-pages'), $imageName);
            $image = $image->getFilename();
        }else{
            $image = NULL;
        }

        $data = [
            'title' => $titleData,
            'text' => $descriptionData,
            'image' => $image,
            'type' => $request->type,
        ];

        return $data;
    }
}
