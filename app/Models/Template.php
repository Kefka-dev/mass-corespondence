<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Template extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'template',
        'subject',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
