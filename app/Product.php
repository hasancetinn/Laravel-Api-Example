<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property mixed slug
 * @property mixed price
 */

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'price'];
//    protected $hidden = ['slug'];

    public function categories(){

        return $this->belongsToMany('App\Category', 'product_categories');
    }

}
