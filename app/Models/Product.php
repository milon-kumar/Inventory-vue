<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function images(){
        return $this->hasMany(Image::class, 'product_id');
    }
}
