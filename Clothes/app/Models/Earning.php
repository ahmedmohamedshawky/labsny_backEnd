<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Earning
 * @package App\Models
 * @version March 25, 2020, 9:48 am UTC
 *
 * @property \App\Models\Shop shop
 * @property integer shop_id
 * @property integer total_orders
 * @property double total_earning
 * @property double admin_earning
 * @property double shop_earning
 * @property double delivery_fee
 * @property double tax
 */
class Earning extends Model
{

    public $table = 'earnings';
    


    public $fillable = [
        'shop_id',
        'total_orders',
        'total_earning',
        'admin_earning',
        'shop_earning',
        'delivery_fee',
        'tax'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'shop_id' => 'integer',
        'total_orders' => 'integer',
        'total_earning' => 'double',
        'admin_earning' => 'double',
        'shop_earning' => 'double',
        'delivery_fee' => 'double',
        'tax' => 'double'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'shop_id' => 'required|exists:shops,id'
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
    public function shop()
    {
        return $this->belongsTo(\App\Models\Shop::class, 'shop_id', 'id');
    }
    
}
