<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = ['name', 'status', 'photoUrls'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'photoUrls' => 'array',
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class, 'pets_tags', 'pet_id', 'tag_id');
    }
}
