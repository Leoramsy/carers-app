<?php

namespace App\Http\Controllers\Schedules;

use DB;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\type;
use App\Models\Auth\Role;
use App\Models\System\Gender;
use App\Models\Carers\Detail;
use Illuminate\Http\Request;

class ScheduleController extends EditorController
{

    public $object;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\Carers\User');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        // $get active carers
        $class = $this->getPrimaryClass();
        $carers_query = $class::has('detail')->where('active', TRUE)->orderBy('name')->get();
        $data = [];
        foreach ($carers_query as $carer) {
            $data[] = [
                'id' => $carer->id,
                'title' => $carer->name . ' ' . $carer->surname
            ];
        }
        $carers = json_encode($data);
        return view('schedules.show', compact('carers'));
    }

    /*
     * Get visits for Schedule display for a given period
     * $params Request $request
     */
    public function visits(Request $request)
    {
        try {
            $start_date = toCarbon($request->start);
            $end_date = toCarbon($request->end);
            // query the applicable visits here
            // format the visits for each
            return response()->json(['data' => []]);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    protected function format($entry)
    {
        $role_ids = DB::table('carer_roles')->select('role_id')->where('carer_id', $entry->id)->get()->all();
        return [
            "carers" => [
                "id" => $entry->id,
                "name" => $entry->name,
                "surname" => $entry->surname,
                "email" => $entry->email,
                "active" => $entry->active,
                "username" => $entry->username,
            ],
            "carer_details" => [
                'gender_id' => $entry->gender_id,
                'health_care_number' => $entry->health_care_number,
                'employee_number' => $entry->employee_number,
                'phone_number' => $entry->phone_number,
                'address_1' => $entry->address_1,
                'address_2' => $entry->address_2,
                'address_3' => $entry->address_3,
                'county' => $entry->county,
                'post_code' => $entry->post_code,
                'address' => $entry->address_1 . ' ' . $entry->address_2 . ' ' . $entry->address_3 . ' ' . $entry->county . ' ' . $entry->post_code,
                'next_of_kin' => $entry->next_of_kin,
                'next_of_kin_phone' => $entry->next_of_kin_phone,
                'next_of_kin_relationship' => $entry->next_of_kin_relationship,
                'date_of_birth' => (is_null($entry->date_of_birth) ? NULL : Carbon::parse($entry->date_of_birth)->format('d/m/Y')),
                'start_date' => (is_null($entry->start_date) ? NULL : Carbon::parse($entry->start_date)->format('d/m/Y')),
                'end_date' => (is_null($entry->end_date) ? NULL : Carbon::parse($entry->end_date)->format('d/m/Y')),
            ],
            "carer_roles[]" => $role_ids,
        ];
    }

    /**
     *
     * @param type $messages
     */
    protected function setMessages($messages = [])
    {
        $this->messages = [
            'carers.email.unique' => 'The email has already been taken by a registered Carer',
            'carers.email.email' => 'This email is not valid',
            'carers.username.unique' => 'The username has already been taken by a registered Carer',
            'carers.password.confirmed' => 'The password doesn\'t match the confirmation password',
            'carers.password.regex' => 'The password must contain at least 1 upper, 1 lower, 1 numeric and 1 special character (@!$#%)',
            'carer_roles.present' => 'Please select one or more Roles',
            'carer_roles.min' => 'Please select one Role for the Carer',
            'min' => 'A minimum value of at least :min is required',
            'required' => 'This field is required',
            'exists' => 'The selected option is invalid',
        ];
        if (count($messages) > 0) {
            $this->messages = array_merge($this->messages, $messages);
        }
    }

    /**
     *
     * @param array $rules
     */
    protected function setRules(array $rules = [])
    {
        $role_list = createValidateList(Role::all());
        $this->rules = [
            'carers.name' => 'required|string|min:3',
            'carers.surname' => 'required|string|min:3',
            'carer_details.phone_number' => 'required|string|min:5',
            'carers.email' => 'required|email|unique:carers,email,' . (is_null($this->primary_key) ? 'NULL' : $this->primary_key) . ',id',
            'carers.username' => 'required|string|unique:carers,username,' . (is_null($this->primary_key) ? 'NULL' : $this->primary_key) . ',id',
            'carer_roles' => 'present|array|min:1',
            'carer_roles.*.role_id' => 'required|integer|in:' . $role_list,
            'carer_details.gender_id' => 'required|integer|exists:genders,id',
            'carer_details.date_of_birth' => 'nullable|date',
            'carer_details.start_date' => 'nullable|date',
            'carer_details.end_date' => 'nullable|date',
            'carer_details.address_1' => 'required|string|min:3',
            'carer_details.address_2' => 'nullable|string|min:3',
            'carer_details.county' => 'nullable|string|min:3',
            'carer_details.post_code' => 'nullable|string|min:3',
            'carer_details.next_of_kin' => 'nullable|string|min:3',
        ];
        if ($this->getAction() == self::ACTION_CREATE) {
            $this->rules['carers.password'] = [
                'required',
                'confirmed',
                'string',
                'min:8', // must be at least 8 characters in length
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@!$#%]/', // must contain a special character
            ];
        }

        if ($this->getAction() == self::ACTION_EDIT && key_exists('carers.password', $this->getIncludedFields())) {
            $this->rules['carers.password'] = [
                'required',
                'confirmed',
                'string',
                'min:8', // must be at least 8 characters in length
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@!$#%]/', // must contain a special character
            ];
        }
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
    }
}
