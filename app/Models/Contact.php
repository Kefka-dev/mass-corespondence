<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'use_vykanie',
        'oslovenie',
        'user_id',
    ];
    protected $casts = [
        'use_vykanie' => 'boolean',
    ];

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //
}
