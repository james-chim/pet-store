<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // not needed as we don't query pet from category
//    public function pets()
//    {
//        return $this->hasMany(Pets::class);
//    }
}
