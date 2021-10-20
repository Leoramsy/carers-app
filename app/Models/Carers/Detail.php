<?php

namespace App\Models\Carers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carer_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['carer_id', 'gender_id', 'health_care_number', 'employee_number',
        'phone_number', 'address_1', 'address_2', 'address_3', 'county', 'post_code', 'next_of_kin',
        'next_of_kin_phone', 'next_of_kin_relationship'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = ['date_of_birth', 'start_date', 'end_date'];

    /**
     * Get the Carer this Detail belongs to
     *
     * @return User
     */
    public function carer()
    {
        return $this->belongsTo('App\Models\Carers\User', 'carer_id', 'id');
    }

    /**
     *
     * @return boolean
     */
    public function isLinked()
    {
        switch (true) {
            case $this->carer()->count() > 0:
                return 'Company';
        }
    }
}
