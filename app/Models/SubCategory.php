<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function color()
    {
        return $this->belongsTo(\App\Models\ColourCategory::class, 'color_id');
    }
    public function size()
    {
        return $this->belongsTo(\App\Models\SizeCategory::class, 'size_id');
    }
    public function clothesCategory()
    {
        return $this->belongsTo(\App\Models\ClothesCategory::class, 'clothes_category_id');
    }
    public function shopCategory()
    {
        return $this->belongsTo(\App\Models\ShopCategory::class, 'shop_category_id');
    }
    public function clothes()
    {
        return $this->hasMany(\App\Models\Clothes::class,'clothes_id');
    }
}
