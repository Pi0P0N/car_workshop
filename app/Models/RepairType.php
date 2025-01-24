<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairType extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'description',
    ];

    public function repairs()
    {
        return $this->hasMany(Repairs::class);
    }
}
