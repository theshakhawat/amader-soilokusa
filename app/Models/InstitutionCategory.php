<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class InstitutionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function institutions(): HasMany
    {
        return $this->hasMany(Institution::class, 'institution_category_id');
    }

    protected static function booted()
    {
        static::saving(function ($category) {
            if (empty($category->slug)) {
                $base = Str::slug($category->name);
                if (empty($base)) {
                    $base = 'category-' . uniqid();
                }
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $category->id ?? 0)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $category->slug = $slug;
            }
        });
    }
}

