<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'rental_price', 'image', 'github_link', 'itchio_link', 'label'];

    protected $casts = [
        'github_link' => 'string',
        'itchio_link' => 'string',
    ];

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
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
}
