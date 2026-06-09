<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'start_date', 'end_date',
        'status', 'payment_status', 'github_link', 'itchio_link',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'github_link' => 'string',
            'itchio_link' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function setGithubLinkAttribute($value)
    {
        $this->attributes['github_link'] = $this->sanitizeLink($value);
    }

    public function setItchioLinkAttribute($value)
    {
        $this->attributes['itchio_link'] = $this->sanitizeLink($value);
    }

    private function sanitizeLink($value): ?string
    {
        $value = trim((string) $value);

        if ($value === '' || $value === '0' || strtolower($value) === 'null') {
            return null;
        }

        return $value;
    }

    public function getIsAccessibleAttribute(): bool
    {
        return $this->status === 'active'
            && $this->payment_status === 'paid'
            && $this->end_date >= now()->toDateString();
    }
}
