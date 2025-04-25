<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'total_price'];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
