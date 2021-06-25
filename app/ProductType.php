<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $guarded = [];
    protected $fillable = ['name', 'image'];
    public $timestamps = true;

    public function products() {
        return $this->hasMany(Product::class);
    }
}
