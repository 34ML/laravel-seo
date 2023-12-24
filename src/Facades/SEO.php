<?php

namespace _34ML\SEO\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \34ML\SEO\SEO
 */
class SEO extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \_34ML\SEO\SEO::class;
    }
}
