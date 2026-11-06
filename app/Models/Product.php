<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'precio', 
        'imagen', 
        'categoria',
        'stock_s',
        'stock_m',
        'stock_l',
        'stock_xl',
        'stock_26',
        'stock_27',
        'stock_28',
        'stock_29',
        'stock',
    ];
}