<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{
    public function handleCacheHit(CacheHit $event): void
    {
        Log::info("{$event->key} cache hit");
    }

    public function handleCacheMissed(CacheMissed $event): void
    {
        Log::info("{$event->key} cache miss");
    }

    public function subscribe($events)
    {
        $events->listener(
            CacheHit::class,
            'App\Listeners\CacheSubscriber@handleCacheHit'
        );

        $events->listener(
            CacheMissed::class,
            'App\Listeners\CacheSubscriber@handleCacheMissed'
        );
    }
}
