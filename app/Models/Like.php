<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $table = 'likes';
    
    public $fillable = [
        'manager_id',
        'clothes_id',
        'client_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'manager_id' => 'integer',
        'client_id' => 'integer',
        'clothes_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'manager_id' => 'required|exists:users,id',
        'client_id' => 'required|exists:users,id',
        'clothes_id' => 'required|exists:clothes,id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTp
     **/
    public function clothes()
    {
        return $this->belongsTo(\App\Models\Clothes::class, 'clothes_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\User::class, 'client_id', 'id');
    }

    public function manager()
    {
        return $this->belongsTo(\App\Models\User::class, 'manager_id', 'id');
    }
}
