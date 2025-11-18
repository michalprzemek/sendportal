<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubscriptionForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'workspace_id',
        'name',
        'subscriber_list_id',
        'html_content',
        'redirect_after_subscribe_url',
        'redirect_after_confirm_url',
        'welcome_email_template_id',
        'is_captcha_enabled',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($form) {
            $form->uuid = (string) Str::uuid();
        });
    }
}
