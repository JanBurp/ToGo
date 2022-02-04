<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Locations extends Model
{
    use HasFactory;

    /**
     * Create nice slug from location name
     */
    protected static function boot() {
        parent::boot();

        static::creating(function ($location) {
            $location->slug = Str::slug($location->location);
        });

        static::updating(function ($location) {
            $location->slug = Str::slug($location->location);
        });

    }

}
