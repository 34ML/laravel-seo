<?php

namespace _34ML\SEO\Helpers;

class Seo
{
    /**
     * Build the SEO array for a given page
     */
    public static function renderAttributes(string $title = '', string $description = '', string $keywords = '', string $follow_type = 'index, follow'): array
    {
        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'follow_type' => $follow_type,
        ];
    }
}
