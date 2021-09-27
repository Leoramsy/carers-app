<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{

    const MALE = 'male';
    const FEMALE = 'female';    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'genders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'slug'];

    /**
     * one-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function clients() {
        return $this->hasMany('App\Models\Clients\Client');
    }

    /**
     * 
     * @return boolean
     */
    public function isLinked() {
        switch (true) {
            case $this->clients()->count() > 0:
                return 'Clients';            
        }
    }

}
