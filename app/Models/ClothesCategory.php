<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothesCategory extends Model
{
    public $table = 'clothes_categories';
    
    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required'
    ];
 
}
