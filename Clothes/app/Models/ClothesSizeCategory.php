<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothesSizeCategory extends Model
{
    public $table = 'clothes_size_categories';
    
    public $fillable = [
        'clothes_id',
        'size_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'clothes_id' => 'integer',
        'size_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'clothes_id' => 'required|exists:clothes,id',
        'size_id' => 'required|exists:size_categories,id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sizeCategory()
    {
        return $this->hasMany(\App\Models\SizeCategory::class, 'id')->select(['id', 'name']);
    }
}
