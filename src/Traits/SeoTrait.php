<?php

namespace _34ML\SEO\Traits;

use _34ML\SEO\SEO;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait SeoTrait
{
    private array $title = [];

    private array $description = [];

    private array $keywords = [];

    private $follow = null;

    /**
     * Get the seo_model relationship.
     */
    public function seo_model(): MorphOne
    {
        return $this->morphOne(SEO::class, 'seo_model');
    }

    /**
     * Return the seo_model data as array
     *
     * @throws \Exception
     */
    public function getSeoModel(): array
    {
        $attrs = false;
        if ($this->seo_model) {
            $attrs = $this->seo_model->toArray();
        } else {
            $this->setDefaultValues();
            if ($this->validateTitleExistsForAnyLocale()) {
                $formatter = $this->getSeoTitleFormatter() ?? config('seo.title_formatter');
                $attrs = [
                    'title' => $this->title,
                    'description' => $this->description,
                    'keywords' => $this->keywords,
                    'follow_type' => $this->follow,
                    'params' => (object) [
                        'title_format' => $formatter,
                    ],
                ];
            }
        }

        return $attrs;
    }

    /**
     * Get SEO title formatter
     */
    public function getSeoTitleFormatter()
    {
        return config('seo.title_formatter');
    }

    /**
     * Get default SEO title
     */
    public function getSeoTitleDefault(): array
    {
        return $this->title;
    }

    /**
     * Get default SEO description
     */
    public function getSeoDescriptionDefault(): array
    {
        return $this->description;
    }

    /**
     * Get default SEO keywords
     */
    public function getSeoKeywordsDefault(): array
    {
        return $this->keywords;
    }

    /**
     * Get default SEO follow type
     */
    public function getSeoFollowDefault(): ?string
    {
        return $this->follow;
    }

    /**
     * @throws \Exception
     */
    public function buildSeoForCurrentLocale(): array
    {
        $seo = $this->getSeoModel();
        $fallback_locale = config('seo.fallback_locale');
        $translatable_keys = ['title', 'description', 'keywords'];
        $locale = app()->getLocale();
        foreach ($translatable_keys as $key) {
            if (isset($seo[$key])) {
                if (isset($seo[$key][$locale]) && ! empty($seo[$key][$locale])) {
                    $seo[$key] = $seo[$key][$locale];
                } elseif (isset($seo[$key][$fallback_locale]) && ! empty($seo[$key][$fallback_locale])) {
                    $seo[$key] = $seo[$key][$fallback_locale];
                } else {
                    $seo[$key] = null;
                }
            } else {
                $seo[$key] = null;
            }
        }

        return $seo;
    }

    private function validateTitleExistsForAnyLocale(): bool
    {
        $locale = app()->getLocale();
        $fallback_locale = config('seo.fallback_locale');
        $exists = false;
        $title = $this->title;
        if (isset($title[$locale]) && ! empty($title[$locale])) {
            $exists = true;
        } elseif (isset($title[$fallback_locale]) && ! empty($title[$fallback_locale])) {
            $exists = true;
        }

        return $exists;
    }

    /**
     * Set the default values from the config
     * then call the registerDefaultValues function to override
     * them if the user added new default values
     */
    private function setDefaultValues(): void
    {
        foreach (config('seo.available_locales') as $locale) {
            $this->addTitleDefault(config('seo.default_seo_title', $locale));
            $this->addDescriptionDefault(config('seo.default_seo_description', $locale));
            $this->addKeywordsDefault(config('seo.default_seo_keywords', $locale));
        }
        $this->addFollowDefault(config('seo.default_follow_type'));
        // override by user defaults if exists
        $this->registerDefaultValues();
    }

    /**
     * REGISTERING THE DEFAULT VALUES IF EXISTS
     */
    public function registerDefaultValues(): void
    {

    }

    public function addTitleDefault(?string $value = null, ?string $locale = null): void
    {
        if (! $locale) {
            $locale = config('seo.fallback_locale');
        }
        $this->title[$locale] = $value;
    }

    public function addDescriptionDefault(?string $value = null, ?string $locale = null): void
    {
        if (! $locale) {
            $locale = config('seo.fallback_locale');
        }
        $this->description[$locale] = $value;
    }

    public function addKeywordsDefault(?string $value = null, ?string $locale = null): void
    {
        if (! $locale) {
            $locale = config('seo.fallback_locale');
        }
        $this->keywords[$locale] = $value;
    }

    public function addFollowDefault(string $value): void
    {
        $this->follow = $value;
    }
}
