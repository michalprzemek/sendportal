<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomationEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'automation_id',
        'template_id',
        'delay_in_hours',
    ];

    public function automation(): BelongsTo
    {
        return $this->belongsTo(Automation::class);
    }
}
