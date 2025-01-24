<?php

namespace App\Models;

use PaymentStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'repair_id',
        'status',
        'amount',
        'client_id',
        'employee_id'
    ];

    public function repair()
    {
        return $this->belongsTo(Repairs::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute($value)
    {
        return PaymentStatusEnum::fromValue($value);
    }
}
