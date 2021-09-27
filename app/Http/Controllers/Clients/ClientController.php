<?php

namespace App\Http\Controllers\Clients;

use DB;
use App\Http\Controllers\EditorController;
//use App\Models\Clients\Client;
use App\Models\System\Gender;
use Illuminate\Http\Request;

class ClientController extends EditorController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\Clients\Client');
    }  
    
    // construct
    // view
    // getRows - index
    // OPTIONAL
    // getOptions
    // create
    //edit
    // delete
    //setMessages
    
    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request) {
        $user = $request->user();
        $company = $user->company;
        $filters = getFilters($request);
        $class = $this->getPrimaryClass();
        $clients = selectTwoOptions($class::select('id', DB::raw("CONCAT(name, ' ', surname) AS description"))->where('company_id', $company->id)->orderBy('first_name')->get(), "Select Client");
        $active = [1 => "Yes", 0 => "No"];
        $genders = selectTwoOptions(Gender::select('id', 'description')->orderBy('description')->get(), "Select Gender");
        if ($request->ajax()) {
            setFilters($request);            
            $client_query = $class::select('clients.*', 'genders.description AS gender')
                    ->join('companies', 'clients.company_id', '=', 'companies.id')
                    ->leftjoin('genders', 'clients.gender_id', '=', 'genders.id')
                    ->where('clients.company_id', $company->id)
                    ->where('clients.company_id', $request->active_id);
            if ($request->client_id > 0) {
                $client_query->where('clients.id', $request->client_id);
            }
            if ($request->gender_id > 0) {
                $client_query->where('clients.gender_id', $request->gender_id);
            }            
            $clients = $client_query->get();
            $data = [];
            foreach ($clients AS $client) {
                $data[] = $client->process();
            }
            return response()->json(["data" => $data,]);
        }
        return view('staff.clients.clients', compact('clients', 'genders', 'active', 'filters'));
    }
    
    /**
     * Return a list of resource.
     * 
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    protected function getRows(Request $request, $id = 0) {
        $object = $this->getPrimaryClass();
        $query = $object::select(['clients.*', DB::raw("DATE_FORMAT(clients.created_at, '%d/%m/%Y %H:%i') AS formatted_created_at,"
                . " DATE_FORMAT(clients.updated_at, '%d/%m/%Y %H:%i') AS formatted_updated_at ")]);
        if ($id > 0) {
            return $query->where('clients.id', $id)->first();
        }
        return $query->get();
    }
    
    /**
     * @return \App\Http\Controllers\type|array
     */
    protected function getOptions() {
        $genders = Gender::select('id', 'description')->orderBy('description')->get();
       // $exisitng_clients = DB::table('clients')->select('id')->get();        
        $gender_options = editorOptions($genders, ["value" => 0, "label" => "Select Gender"]);
        return [            
            "genders.id" => $gender_options
        ];
    }
    /**
     * 
     * @param array $rules
     */
    protected function setRules(array $rules = []) {
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
    }

    /**
     *
     * @param array $messages
     */
    protected function setMessages($messages = []) {
        $this->messages = [
            'required' => 'This field is required',
            'numeric' => 'Please enter a numeric value',
            'email' => 'Please enter a valid email',
            'before' => 'Date cannot be in the future',
            'unique' => 'This value has been taken, please choose another one',
            "min" => "The field requires more input, a minimum of :min characters",
            "max" => "The maximum limit (:max) has been reached"
        ];
        if (count($messages) > 0) {
            $this->messages = array_merge($this->messages, $messages);
        }
    }

    /**
     * 
     * @return array
     */
    protected function format($client) {
        return [
            "clients" => [
                "id" => $client->id,
                "company_id" => $client->company_id,
                "health_care_number" => $client->health_care_number,
                "customer_number" => $client->customer_number,                
                "gender_id" => $client->gender_id,
                "name" => $client->name,
                "surname" => $client->surname,
                "phone" => $client->phone,
                "phone_2" => $client->phone_2,                
                "address_1" => $client->address_1,
                "address_2" => $client->address_2,
                "city" => $client->city,
                "county" => $client->county,                
                "postal_code" => $client->postal_code,
                "general_notes" => $client->general_notes,
                "private_notes" => $client->private_notes,
                "accomodation_notes" => $client->accomodation_notes,                
                "access_to_home" => $client->access_to_home,
                "door_code" => $client->door_code,
                "service_start_date" => $client->service_start_date,
                "service_end_date" => $client->service_end_date,                
                "active" => $client->active,                
                "formatted_created_at" => $client->formatted_created_at,
                "formatted_updated_at" => $client->formatted_updated_at,
                "created_at" => $client->created_at,
                "updated_at" => $client->updated_at,
            ]
        ];
    }

}
