# Laravel SEO

This package will help you to manage your website SEO easily.

## Installation

You can install the package via composer:

```bash
composer require 34ml/laravel-seo
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="seo-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="seo-config"
```

This is the contents of the published config file:

```php
return [
/*
    |--------------------------------------------------------------------------
    | SEO status
    |--------------------------------------------------------------------------
    |
    | Set SEO status, if its set to false then all pages will have
    | the 'noindex, nofollow' follow type and also removed the meta tags except the title tag.
    |
    */

    'seo_status' => env('SEO_STATUS', true),

    /*
    |--------------------------------------------------------------------------
    | Sitemap status
    |--------------------------------------------------------------------------
    |
    | Should there be a sitemap available
    |
    */
    'sitemap_status' => env('SITEMAP_STATUS', false),

    /*
    |--------------------------------------------------------------------------
    | SEO title formatter
    |--------------------------------------------------------------------------
    |
    | If you want a specific default format for your SEO titles, then you can
    | specify it here. Example could be ':text - Test site', then all pages would have
    | the ' - Test site' appended to the actual SEO title.
    |
    */
    'title_formatter' => ':text',

    /*
    |--------------------------------------------------------------------------
    | Follow type options
    |--------------------------------------------------------------------------
    |
    | Here is all the possible follow types shown in the admin panel
    | which is an array with key -> value.
    |
    */

    'follow_type_options' => [
        'index, follow' => 'Index and follow',
        'noindex, follow' => 'No index and follow',
        'index, nofollow' => 'Index and no follow',
        'noindex, nofollow' => 'No index and no follow',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default follow type
    |--------------------------------------------------------------------------
    |
    | Set the default follow type.
    |
    */
    'default_follow_type' => env('SEO_DEFAULT_FOLLOW_TYPE', 'index, follow'),

    /*
      * SEO default title
      */
    'default_seo_title' => config('app.name'),

    /*
      * SEO default description
      */
    'default_seo_description' => null,

    /*
      * SEO default keywords
     * ex : keyword1, keyword2, keyword3
      */
    'default_seo_keywords' => null,

    /*
     *
     */
    /*
    |--------------------------------------------------------------------------
    | Sitemap models
    |--------------------------------------------------------------------------
    |
    | Insert all the laravel models which should be in the sitemap
    |
    */

    'sitemap_models' => [],

    /*
    |--------------------------------------------------------------------------
    | Sitemap url
    |--------------------------------------------------------------------------
    |
    | Set the path of the sitemap
    |
    */

    'sitemap_path' => '/sitemap',
    /*
    |--------------------------------------------------------------------------
    | Available Locales
    |--------------------------------------------------------------------------
    |
    | Set the available locales in your project and fallback locale
    |
    */

    'available_locales' => ['en'],
    'fallback_locale' => 'en',
];
```

## Usage

Find the model you want to have the SEO fields on, example could be App\Models\Page, then add the SeoTrait trait:
```php
use _34ML\SEO\Traits\SeoTrait;

class Page extends Model
{
    use SeoTrait;
    ...
}
```

When you want the eloquent model to be shown in the sitemap then you need to add the SeoSiteMapTrait trait to it:
```php
use _34ML\SEO\Traits\SeoTrait;
use _34ML\SEO\Traits\SeoSiteMapTrait;

class Page extends Model
{
    use SeoTrait, SeoSiteMapTrait;
    ...

    /**
     * Get the Page url by item
     *
     * @return string
     */
    public function getSitemapItemUrl()
    {
        return url($this->slug);
    }

    /**
     * Query all the Page items which should be
     * part of the sitemap (crawlable for google).
     *
     * @return Builder
     */
    public static function getSitemapItems()
    {
        return static::all();
    }
}
```

Then go to the top of your layout blade as the default is resources/views/welcome.blade.php:
```html
...
<head>
    @include('laravel-seo::seo')
    ...
</head>
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Ahmed Essam](https://github.com/aessam13)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
