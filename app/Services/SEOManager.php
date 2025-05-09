<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\SEOMeta;

class SEOManager
{
    public function setMetaTags($title, $description, $city)
    {
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCity($city);
    }
}
