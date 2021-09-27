<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'health_care_number', 'customer_number', 'gender_id', 'name', 'surname',
        'phone', 'phone_2', 'address_1', 'address_2', 'city', 'county', 'postal_code', 'email',
        'general_notes', 'private_notes', 'accomodation_notes', 'access_to_home', 'door_code', 
        'service_start_date', 'service_end_date', 'email', 'active'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = ['service_start_date', 'service_end_date'];

    /**
     * Get the company this customer belongs to
     * 
     * @return Company
     */
    public function company() {
        return $this->belongsTo('App\Models\System\Company', 'company_id', 'id');
    }

    /**
     * 
     * @return boolean
     */
    public function isLinked() {
        switch (true) {
            case $this->company()->count() > 0:
                return 'Company';            
        }
    }

}

