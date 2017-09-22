<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User_account extends Model{

    protected $table='user_accounts';

    protected $fillable= [
        'provider',
        'puid'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
