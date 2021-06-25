<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    protected $fillable = ['name', 'product_type_id', 'stock', 'price', 'description', 'image'];
    public $timestamps = true;

    public function productType() {
        return $this->belongsTo(ProductType::class);
    }

    public function transactionDetails() {
        return $this->belongsToMany(TransactionDetail::class);
    }

    public function cartItems() {
        return $this->belongsToMany(CartItem::class);
    }
}
