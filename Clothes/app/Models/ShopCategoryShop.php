<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryShop extends Model
{
    public $table = 'shop_category_shops';
    
    public $fillable = [
        'shop_id',
        'shop_category_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'shop_id' => 'integer',
        'shop_category_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'shop_id' => 'required|exists:shops,id',
        'shop_category_id' => 'required|exists:shop_categories,id',
    ];

}
