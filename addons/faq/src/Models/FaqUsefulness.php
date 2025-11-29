<?php

namespace App\Addons\Faq\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqUsefulness extends Model
{
    protected $table = 'faq_usefulness';

    protected $fillable = [
        'faq_id',
        'ip_address',
        'is_useful',
    ];

    protected $casts = [
        'is_useful' => 'boolean',
    ];

    public function faq(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }
}
