<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ClothesReview
 * @package App\Models
 * @version August 29, 2019, 9:38 pm UTC
 *
 * @property \App\Models\User user
 * @property \App\Models\Clothes clothes
 * @property string review
 * @property unsignedTinyInteger rate
 * @property integer user_id
 * @property integer clothes_id
 */
class ClothesReview extends Model
{

    public $table = 'clothes_reviews';
    


    public $fillable = [
        'review',
        'rate',
        'user_id',
        'clothes_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'review' => 'string',
        'user_id' => 'integer',
        'clothes_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|exists:users,id',
        'clothes_id' => 'required|exists:clothes,id',
        'review' => 'required',
        'rate' => 'required',
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',
        
    ];

    public function customFieldsValues()
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }

    public function getCustomFieldsAttribute()
    {
        $hasCustomField = in_array(static::class,setting('custom_field_models',[]));
        if (!$hasCustomField){
            return [];
        }
        $array = $this->customFieldsValues()
            ->join('custom_fields','custom_fields.id','=','custom_field_values.custom_field_id')
            ->where('custom_fields.in_table','=',true)
            ->get()->toArray();

        return convertToAssoc($array,'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function clothes()
    {
        return $this->belongsTo(\App\Models\Clothes::class, 'clothes_id', 'id');
    }
    
}
