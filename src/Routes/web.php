<?php

use _34ML\SEO\Helpers\SeoSiteMap;
use Illuminate\Support\Facades\Route;

if (config('seo.sitemap_status')) {
    Route::get(config('seo.sitemap_path'), function () {
        $sitemap = new SeoSiteMap();

        return response($sitemap->toXml(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    });
}
