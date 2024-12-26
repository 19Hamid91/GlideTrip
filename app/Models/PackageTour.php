<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageTour extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public $routeKeyName = 'slug';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function package_photos()
    {
        return $this->hasMany(PackagePhoto::class);
    }
}
