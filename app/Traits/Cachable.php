<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait Cachable
{
    /**
     * Return the default relationship collection
     *
     * @return Collection
     */
    abstract protected function getDefaultRelation(): Collection;

    /**
     * Get cached key
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        return strtolower(class_basename($this)) . '-cache-' . $this->id;
    }

    /**
     * Get cached relationship.
     *
     * @return void
     */
    public function cachRelation(): void
    {
        // forget prevuious cache
        $this->forgetCache();

        Cache::rememberForever($this->getCacheKey(), function () {
            return $this->getDefaultRelation();
        });
    }


    /**
     * Get cached or return a default value
     *
     * @return Collection
     */
    public function getCache(): Collection
    {
        return Cache::get($this->getCacheKey(), $this->getDefaultRelation());
    }


    /**
     * Forget cached values based on key
     *
     * @return void
     */
    public function forgetCache(): void
    {
        Cache::forget($this->getCacheKey());
    }
}
