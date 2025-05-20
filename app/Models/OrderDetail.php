<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    
    protected $fillable = [
        'order_id',
        'kodemenu',
        'quantity',
        'price'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'kodemenu', 'kodemenu');
    }
}