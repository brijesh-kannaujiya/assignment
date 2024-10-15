<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $guarded = [''];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Define a relationship to delivery personnel
    public function deliveryPersonnel()
    {
        return $this->belongsTo(DeliveryPersonnel::class,'delivery_person_id','id');
    }

}
