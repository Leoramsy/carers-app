<?php

namespace App\Http\Controllers\Carers;

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

class DetailController extends EditorController
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
        return view('carers.details.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = Carbon::now();
        DB::beginTransaction();
        try {
            $class = $this->getPrimaryClass();
            $object = new $class();
            $this->object = $object;
            $data = $this->data[$object->getTable()];
            $role_ids = ($this->data["carer_roles-many-count"] > 0 ? array_pluck($this->data["carer_roles"], 'role_id') : []);
            $this->setIncludedFields(['carer_roles.*.role_id' => $role_ids]);
            $this->setMappedFields(['carer_roles[].role_id' => ['carer_roles', 'carer_roles.*.role_id']]);
            $details = $this->data["carer_details"];
            foreach ($details as $key => $detail) {
                $this->setIncludedFields(['carer_details.' . $key => $detail]);
            }
            if (!$this->isValid($request)) {
                return response()->json(['fieldErrors' => $this->getFieldErrors()]);
            }
            $object->fill($data);
            $object->password = bcrypt($data['password']);
            if (!$object->save()) {
                $this->setError('Failed to create the entry');
            }
            $object->roles()->attach($role_ids, ['created_at' => $object->created_at, 'updated_at' => $object->updated_at]);
            // add details
            $carer_details = new Detail();
            $carer_details->fill($this->data["carer_details"]);
            $carer_details->carer_id = $object->id;
            $carer_details->date_of_birth = (is_null($this->data["carer_details"]["date_of_birth"]) ? NULL : Carbon::parse($this->data["carer_details"]["date_of_birth"]));
            $carer_details->start_date = (is_null($this->data["carer_details"]["start_date"]) ? NULL : Carbon::parse($this->data["carer_details"]["start_date"]));
            $carer_details->end_date = (is_null($this->data["carer_details"]["end_date"]) ? NULL : Carbon::parse($this->data["carer_details"]["end_date"]));
            if (!$carer_details->save()){
                throw new Exception("failed to create Carer Detals");
            }
            ($this->hasErrors() ? DB::rollback() : DB::commit());
            return response()->json($this->output($this->getRows($request, $object->id)));
        } catch (Exception $ex) {
            DB::rollback();
            $response = ['error' => $ex->getMessage()];
            if ($ex instanceof EditorException) {
                if ($ex->requiresConfirmation()) {
                    $response['confirm'] = true;
                }
            }
            if (!app()->environment('production')) {
                $response['file'] = $ex->getFile();
                $response['line'] = $ex->getLine();
                //dd($response, $ex->getTrace());
                $response['trace'] = $ex->getTraceAsString(); //Array Trace Doesn't work with aJax
            }
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $entry_id = formatEditorPrimaryKey($id);
        DB::beginTransaction();
        try {
            $class = $this->getPrimaryClass();
            $object = $class::findOrFail($entry_id);
            $this->object = $object;
            $data = $this->data[$object->getTable()];
            $role_ids = ($this->data["carer_roles-many-count"] > 0 ? array_pluck($this->data["carer_roles"], 'role_id') : []);
            $this->setIncludedFields(['carer_roles.*.role_id' => $role_ids]);
            $this->setMappedFields(['carer_roles[].role_id' => ['carer_roles', 'carer_roles.*.role_id']]);
            //dd(isset($data["password"]) && strlen($data["password"]) > 0);
            if (isset($data["password"]) && strlen($data["password"]) > 0) {
                $this->setIncludedFields(['carers.password' => $data["password"]]);
            }
            if (isset($data["password_confirmation"]) && strlen($data["password_confirmation"]) > 0) {
                $this->setIncludedFields(['carers.password_confirmation' => $data["password_confirmation"]]);
            }
            if (!$this->isValid($request)) {
                return response()->json(['fieldErrors' => $this->getFieldErrors()]);
            }
            if (isset($data["first_name"])) {
                $object->first_name = $data["first_name"];
            }
            if (isset($data["last_name"])) {
                $object->last_name = $data["last_name"];
            }
            if (isset($data["email"])) {
                $object->email = $data["email"];
            }
            if (isset($data["enabled"])) {
                $object->enabled = $data["enabled"];
            }
            if (isset($data["password"])) {
                $object->password = bcrypt($data['password']);
            }
            if (!$object->save()) {
                $this->setError('Failed to create the entry');
            }
            // Update carer Roles
            if (isset($this->data["carer_roles-many-count"])) {
                $role_ids = ($this->data["carer_roles-many-count"] > 0 ? array_pluck($this->data["carer_roles"], 'role_id') : []);
                $object->roles()->sync($role_ids, ['created_at' => $object->updated_at, 'updated_at' => $object->updated_at]);
                $admin_roles = Role::whereIn('slug', [Role::SUPER_ADMIN, Role::ADMIN])->get();
                if (count(array_intersect($role_ids, $admin_roles->pluck('id')->all()))) {
                    $object->generateToken();
                }
            }
            DB::commit();
            return response()->json($this->output($this->getRows($request, $object->id)));
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $entry_id = formatEditorPrimaryKey($id);
        DB::beginTransaction();
        try {
            $class = $this->getPrimaryClass();
            $object = $class::findOrFail($entry_id);
            if ($object->batches()->count() > 0) {
                throw new Exception("This carer has one or more active Report Batches and cannot be deleted");
            }
            if ($object->emailBatches()->count() > 0) {
                throw new Exception("This carer has one or more active Report Batches and cannot be deleted");
            }
            $this->object = $object;
            $object->roles()->detach();
            $object->clients()->detach();
            if (!$object->delete()) {
                throw new Exception("Failed to remove carer");
            }
            DB::commit();
            return response()->json(['data' => []]);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Validates the incoming data against the models rules     *
     * @return boolean
     */
    protected function isValid()
    {
        if ($this->getAction() != self::ACTION_REMOVE) {
            $this->initRules();
            $data = $this->getValidationData();
            $this->v = Validator::make($data, $this->getRules(), $this->getMessages()); //$this->complex(); //Removed, as the laravel function for making complex 'sometimes' rule wasn't working.
            if ($this->v->fails()) {
                $messages = $this->v->messages();
                foreach (array_keys($this->rules) as $key) {
                    $fieldError = $this->getValidationError($key, $messages->first($key));
                    if (count($fieldError) > 0) {
                        array_push($this->fieldErrors, $fieldError); //['name' => $this->table . '.' . $mappedField, 'status' => $message]
                    }
                }
                return false;
            }
        }
        return true;
    }

    /**
     * Each field must contain at least one '.', set by the getValidationData() method.
     * Field is split up and mapped if required
     *
     * @param type $key
     * @param type $message
     * @return type
     */
    private function getValidationError($key, $message)
    {
        if (strlen($message) == 0 || (strpos($key, '.') === false && !in_array($key, $this->getExcludedFields()))) {
            return [];
        }
        $fieldArray = explode('.', $key); //$field = substr($key, (strpos($key, '.') + 1));
        $field = (count($fieldArray) == 3 ? head($fieldArray) . "[]." . end($fieldArray) : head($fieldArray) . "." . end($fieldArray));
        if (!in_array($key, $this->getExcludedFields()) && !in_array(end($fieldArray), $this->getExcludedFields())) { //Key hasn't been Mapped or Excluded so we can return this error
            return ['name' => $field, 'status' => $message];
        }
        if (count($this->mappedFields) > 0) {
            foreach ($this->mappedFields as $editorField => $mappedField) {
                if (in_array($key, $mappedField) || in_array(end($fieldArray), $mappedField)) { //$key might already be linked to a table, and sometimes our mappedField not include the table. So we check both ways.
                    //Mapped field has been used once, we don't want multiple errors in the $fieldError Array linked to the same field
                    unset($this->mappedFields[$editorField]);
                    return ['name' => (strpos($editorField, '.') !== false ? $editorField : $this->table . '.' . $editorField), 'status' => $message];
                }
            }
        }
    }

    /**
     *
     * @return array
     */
    private function getValidationData(): array
    {
        $data = [$this->object->getTable() => $this->data[$this->object->getTable()]]; //$this->data[$this->object->getTable()];
        if (count($this->getIncludedFields()) == 0) {
            return $data;
        }
        foreach ($this->getIncludedFields() as $field => $value) {
            if (strpos($field, '*') !== false) { //Special occasion, an array is involved, meaning there will be 3 '.'
                $tableField = explode('.', $field);
                $fieldArray = [];
                foreach ($value as $k => $v) {
                    array_push($fieldArray, [end($tableField) => $v]);
                }
                if (isset($data[head($tableField)])) {
                    array_push($data[head($tableField)], $fieldArray);
                } else {
                    $data[head($tableField)] = $fieldArray;
                }
            } else if (strpos($field, '.') !== false) { //this field has been seperated by a '.', meaning there is a table name involved
                $tableField = explode('.', $field);
                if (isset($data[head($tableField)])) { //Table key has already been set, so add onto this array
                    $data[head($tableField)][end($tableField)] = $value;
                } else { //Else it hasn't, therefore set it for the first time!
                    $data[head($tableField)] = [end($tableField) => $value];
                }
            } else { //no table has been defined, so we set it to the default model table
                $data[$this->table] = [$field => $value];
            }
        }
        //dd($data);
        return $data;
    }


    public function getOptions(): array
    {
        $carer = auth()->user();
        if ($carer->is_admin) {
            $roles = Role::select('id', 'title AS description')->orderBy('title')->get();
        } else {
            $roles = Role::select('id', 'title AS description')->whereNotIn('slug', [Role::SUPER_ADMIN])->orderBy('title')->get();
        }
        $role_options = editorOptions($roles);
        $gender_options = editorOptions(Gender::orderBy('description')->get(), ["value" => 0, "label" => "Select a Gender"]);
        return [
            "carer_roles[].role_id" => $role_options,
            "carer_details.gender_id" => $gender_options
        ];
    }

    public function getRows(Request $request, $id = 0)
    {
        $user = $request->user();
        if ($user->is_admin) {
            $roles = Role::select('id', 'title AS description')->orderBy('title')->get();
        } else {
            $roles = Role::select('id', 'title AS description')->whereNotIn('slug', [Role::SUPER_ADMIN])->orderBy('title')->get();
        }
        $object = $this->getPrimaryClass();
        $data_array = ['carers.id','carers.name', 'carers.surname', 'carers.email', 'carers.active', 'carers.image'];
        $query = $object::select($data_array)
            ->join('carer_roles', 'carers.id', '=', 'carer_roles.carer_id')
            ->whereIn('carer_roles.role_id', $roles->pluck('id')->all())
            //->where('carers.company_id', $user->company_id)
            ->groupBy($data_array);
        if ($id > 0) {
            return $query->where('carers.id', $id)->first();
        }
        return $query->get();
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
                "image" => $entry->image,
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
            'carers.company_id' => 'required|integer|exists:companies,id',
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
