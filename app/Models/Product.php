<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function cart(){
        return $this->belongsToMany(Product::class);
    }
}
