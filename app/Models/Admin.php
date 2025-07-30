<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'id',
        'name',
        'username',
        'phone',
        'email',
        'password'
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
