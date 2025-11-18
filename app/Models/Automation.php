<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Automation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subscriber_list_id',
    ];

    public function emails(): HasMany
    {
        return $this->hasMany(AutomationEmail::class);
    }
}
