<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProfile extends Model
{
    protected $fillable = [
        'greeting',
        'headline',
        'hire_label',
        'hire_url',
        'bio',
        'photo',
        'availability',
        'about_dark_1',
        'about_mute_1',
        'about_dark_2',
        'about_mute_2',
        'about_cta_label',
        'services_heading',
        'services_subtext',
        'services_button_label',
        'showcase_heading',
        'contact_eyebrow',
        'contact_heading',
        'contact_email',
    ];

    public static function current(): self
    {
        return static::query()->first() ?? static::query()->create([]);
    }
}
