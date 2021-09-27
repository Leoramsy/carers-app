<?php

namespace App\Models\System;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'iso_code_s','iso_code_l','iso_numeric','currency','currency_code','currency_indicator'
    ];


    /**
     *
     * @return boolean
     */
    public function isLinked(): bool
    {
        return false; //$this->packaged()->count() > 0;
    }
}
