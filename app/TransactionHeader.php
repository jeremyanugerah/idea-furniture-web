<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    protected $dates = ['date_time'];
    protected $guarded = [];
    protected $fillable = ['user_id', 'date_time'];
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails() {
        return $this->hasMany(TransactionDetail::class, 'transaction_header_id', 'id');
    }
}
