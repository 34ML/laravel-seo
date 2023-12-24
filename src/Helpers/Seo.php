<?php

namespace _34ML\SEO\Helpers;

use Illuminate\Support\Facades\Storage;

class Seo
{
    /**
     * Build the SEO array for a given page
     *
     * @param string $title
     * @param string $description
     * @param string $keywords
     * @param string|null $image
     * @param string $follow_type
     *
     * @return array
     */
    public static function renderAttributes(string $title = '', string $description = '', string $keywords = '', string $image = null, string $follow_type = 'index, follow'): array
    {
        if (!$image && config('seo.default_seo_image')) {
            $image = asset(config('seo.default_seo_image'));
        }

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
            'image_path' => $image && !str_contains($image, '//') ? Storage::url($image) : $image,
            'follow_type' => $follow_type
        ];
    }
}
