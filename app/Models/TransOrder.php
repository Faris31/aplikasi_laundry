<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\TransOrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransOrder extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_customer',
        'order_code',
        'order_date',
        'order_end_date',
        'order_status',
        'order_pay',
        'order_change',
        'total'
    ];

    protected $casts = [
        'order_date' => 'date',
        'order_end_date' => 'date',
        'total' => 'decimal:2',
        'order_pay' => 'decimal:2',
        'order_change' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function details()
    {
        return $this->hasMany(TransOrderDetail::class, 'id_order');
    }

    public function pickup()
    {
        return $this->hasOne(TransLaundryPickup::class, 'id_order');
    }

     public function transOrderDetails()
    {
        return $this->hasMany(TransOrderDetail::class, 'id_order');
    }

    public function transLaundryPickups()
    {
        return $this->hasOne(TransLaundryPickup::class, 'id_order');
    }

    public function getStatusTextAttribute()
    {
        return $this->order_status == 0 ? 'baru' : 'selesai';
    }

    public function getStatusClassAttribute()
    {
        return $this->order_status == 0 ? 'bg-warning' : 'bg-success';
    }
}
