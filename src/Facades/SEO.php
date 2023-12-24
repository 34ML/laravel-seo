<?php

namespace 34ML\SEO\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \34ML\SEO\SEO
 */
class SEO extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \34ML\SEO\SEO::class;
    }
}
