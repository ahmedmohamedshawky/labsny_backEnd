<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinStructure extends Model
{
    public $table = 'coin_structures';
    
    public $fillable = [
        'clothes',
        'clothes_featured',
        'offers',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'clothes' => 'float',
        'clothes_featured' => 'float',
        'offers' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'clothes' => 'required',
        'clothes_featured' => 'required',
        'offers' => 'required'
    ];

}
