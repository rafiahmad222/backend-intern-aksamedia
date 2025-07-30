<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Division;

class Employee extends Model
{
    protected $fillable = [
        'id',
        'image',
        'name',
        'phone',
        'division_id',
        'position'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    // Relasi ke Division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('storage/employees/' . $value);
        }
        return null;
    }
}
