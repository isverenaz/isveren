<?php

namespace App\Observers;

use App\Models\Job;
use Illuminate\Support\Facades\Cache;

class JobObserver
{
    public function created(Job $job)
    {
        Cache::forget('cachekey');
    }
}
