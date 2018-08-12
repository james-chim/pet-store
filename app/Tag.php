<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function pets() {
        return $this->belongsToMany(Pet::class, 'pets_tags', 'tag_id', 'pet_id');
    }
}
