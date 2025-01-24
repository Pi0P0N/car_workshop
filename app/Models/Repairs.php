<?php

namespace App\Models;

use App\Enums\RepairStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repairs extends Model
{
    /** @use HasFactory<\Database\Factories\RepairsFactory> */
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'client_id',
        'repair_type',
        'status',
        'description',
        'scheduled_time',
        'scheduled_date'
    ];

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function repairType()
    {
        return $this->belongsTo(RepairType::class, 'repair_type');
    }

    public function getStatusAttribute($value)
    {
        return RepairStatusEnum::fromValue($value);
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
