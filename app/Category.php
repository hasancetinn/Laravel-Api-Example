<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @property mixed name
 * @property mixed slug
 */

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function products(){

        return $this->belongsToMany('App\Product', 'product_categories');
    }
}
