<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'contact_email', 'phone', 'category', 'notes', 'address', 'image_cover', 'logo', 'stars', 'registered_at'])]
class Supplier extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'registered_at' => 'date',
            'stars' => 'integer',
        ];
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}
