<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'postal_address_1', 'postal_address_2', 'postal_address_3', 'postal_post_code',
        'contact_person', 'telephone_number', 'cell_number', 'fax_number', 'email', 'logo', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the Country assigned to this Company 
     *
     * @return Country
     */
    public function country() {
        return $this->belongsTo('App\Models\System\Country', 'country_id', 'id');
    }

    /**
     * Get the Clients that belongs to this Company
     *      
     */
    public function clients() {
        return $this->hasMany('App\Models\Clients\Client', "company_id", "id");
    }    

    /**
     * Get the users that belongs to this Company
     *      
     */
    public function users() {
        return $this->hasMany('App\Models\Carers\User', "company_id", "id");
    }

       /**
     * 
     * @return type
     */
    public function getData() {
        $data = ($this->getAction() == self::ACTION_READ ? $this : $this->queryData());
        return [
            $this->table => [
                "id" => $data->id,
                "country_id" => $data->country_id,
                "name" => $data->name,                
                "postal_address_1" => $data->postal_address_1,
                "postal_address_2" => $data->postal_address_2,
                "postal_address_3" => $data->postal_address_3,
                "postal_post_code" => $data->postal_post_code,
                "contact_person" => $data->contact_person,
                "telephone_number" => $data->telephone_number,
                "cell_number" => $data->cell_number,
                "fax_number" => $data->fax_number,
                "email" => $data->email,
                "logo" => $data->logo,
                "active" => $data->active,
            ]
        ];
    }

    /**
     * 
     * @return type
     */
    public function queryData() {
        return self::select('companies.*')
                        ->where($this->table . '.id', $this->id)->first();
    }

    /**
     * 
     * @param array $rules
     */
    public function setRules(array $rules = []) {
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
    }

    /**
     * 
     * @param type $messages
     */
    public function setMessages(array $messages = []) {
        if (count($messages) > 0) {
            $this->messages = array_merge($this->messages, $messages);
        }
    }

    /**
     * 
     * @return boolean
     */
    public function isLinked() {
        return ($this->users()->count() > 0 || $this->customers()->count() > 0 || $this->customerSupportCategories()->count() > 0 || $this->services()->count() > 0 || $this->suppliers()->count() > 0 || $this->modules()->count() > 0 || $this->invoice_categories()->count() > 0);
    }

}

