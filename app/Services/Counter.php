<?php

namespace App\Services;

// use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session;

class Counter
{
    private $timeout, $cache, $session, $supportsTags;

    public function __construct(Cache $cache, Session $session, int $timeout)
    {
        //this is dependency injection
        $this->timeout = $timeout;
        $this->cache = $cache;
        $this->session = $session;
        $this->supportsTags = method_exists($cache, 'tags');
    }

    public function increment(string $key, array $tags = null): int
    {
        //this is read the current user session id
        $sessionId = $this->session->getId();
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";

        $cache = $this->supportsTags && null !== $tags ? $this->cache->tags($tags) : $this->cache;

        $users = $cache->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        //this $session as key and $lastVisit as value
        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= $this->timeout) { //this is for user more than 1 minutes, so it will remove decrease $difference 
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) >= $this->timeout) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        //this is for store in cache
        $cache->forever($usersKey, $usersUpdate);

        if (!$cache->has($counterKey)) {
            $cache->forever($counterKey, 1);
        } else {
            $cache->increment($counterKey, $difference);
        }

        $counter = $cache->get($counterKey);

        return $counter;
    }
}
