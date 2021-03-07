<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothesCategoryClothes extends Model
{
    public $table = 'clothes_category_clothes';
    
    public $fillable = [
        'clothes_id',
        'clothes_category_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'clothes_id' => 'integer',
        'clothes_category_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'clothes_id' => 'required|exists:clothes,id',
        'clothes_category_id' => 'required|exists:clothes_categories,id',
    ];
}
