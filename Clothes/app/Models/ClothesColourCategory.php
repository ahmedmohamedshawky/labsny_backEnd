<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothesColourCategory extends Model
{
    public $table = 'clothes_colour_categories';
    
    public $fillable = [
        'clothes_id',
        'colour_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'clothes_id' => 'integer',
        'colour_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'clothes_id' => 'required|exists:clothes,id',
        'colour_id' => 'required|exists:colour_categories,id',
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',        
    ];

    public function colourCategory()
    {
        return $this->hasMany(\App\Models\ColourCategory::class, 'id')->select(['id', 'name']);
    }
}
