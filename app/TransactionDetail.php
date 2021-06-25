<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $guarded = [];
    protected $fillable = ['transaction_header_id', 'product_id', 'quantity'];
    public $timestamps = true;

    public function transactionHeader() {
        return $this->belongsTo(TransactionHeader::class);
    }
    
    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
