<?php

namespace _34ML\SEO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SEO extends Model
{
    /**
     * Guarded variables
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Hidden variables
     *
     * @var array
     */
    protected $hidden = [
        'seo_model_type', 'created_at', 'updated_at',
    ];

    /**
     * Table name for the model
     *
     * @var string
     */
    protected $table = 'seo';

    /**
     * Casts variables
     *
     * @var array
     */
    protected $casts = [
        'params' => 'object',
        'title' => 'json',
        'description' => 'json',
        'keywords' => 'json',
    ];

    /**
     * Get the owning seo_model model.
     */
    public function seo_model(): MorphTo
    {
        return $this->morphTo();
    }
}
