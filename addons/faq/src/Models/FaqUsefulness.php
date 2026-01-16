<?php

namespace App\Addons\Faq\Models;

use App\Models\Account\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqUsefulness extends Model
{
    protected $table = 'faq_usefulness';

    protected $fillable = [
        'faq_id',
        'user_id',
        'ip_address',
        'session_hash',
        'is_useful',
    ];

    protected $casts = [
        'faq_id' => 'integer',
        'user_id' => 'integer',
        'is_useful' => 'boolean',
    ];

    public function faq(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}
