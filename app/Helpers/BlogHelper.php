<?php

namespace App\Helpers;
use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogHelper
{
    public static function blogData($request, $guard, $blogImage)
    {
        $titleData = [];
        $descriptionData = [];
        $locales = Translation::where('status', 1)->get();

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : '';
            $titleData[$code] = $request->input("title.$code", '');
            $descriptionData[$code] = $request->input("description.$code", '');
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $image = $request->image->move(public_path('uploads/blogs'), $imageName);
            $image = $image->getFilename();
        } else {

            $image = !empty($blogImage->image)? $blogImage->image: NULL;
        }

        $user_id = auth()->guard($guard)->user()->id;
        $jobData = [
            'user_id' => $user_id,
            'category_id' => $request->category_id,
            'sub_category_id' => (isset($request->sub_category_id) ? $request->sub_category_id : NULL),
            'title' => $titleData,
            'description' => $descriptionData,
            'image' => $image,
            'status' => 1,
            'created_at' => Carbon::now()
        ];

        return $jobData;
    }
}
