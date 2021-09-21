<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Exception;
use Illuminate\Http\Request;
use App\Exceptions\Handle\EditorException;

abstract class EditorController extends DataTablesController {

    /**
     * Create a new controller instance
     *
     * @return void
     */
    const ACTION_CREATE = "create";
    const ACTION_EDIT = "edit";
    const ACTION_REMOVE = "remove";

    /**
     *
     * @var type
     */
    protected $pk_column = 'id';

    /**
     *
     * @var type
     */
    protected $primary_key = null;

    /**
     *
     * @var type
     */
    protected $validation_class = 'Request';

    /**
     * The rules to create
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The rules to create
     *
     * @var array
     */
    protected $messages = [];

    /**
     * If multiple errors occur
     *
     * @var array
     */
    protected $fieldErrors = [];

    /**
     * Fields that shouldn't be included in the fieldErrors response, as they aren't shown on the <form>
     * 
     * @var array
     */
    protected $excludeFields = [];

    /**
     * Fields that aren't apart of the database, but need to be filled in for validation purposes (i.e. confirmation password for users)
     * 
     * @var array
     */
    protected $includeFields = [];

    /**
     * A combination of $excludeFields and $includeFields
     * Allows inputs in the Editor <form> to show fieldErrors from other fields that aren't shown in the <form>
     * 
     * @var array
     */
    protected $mappedFields = [];

    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        if ($request->has('data')) {
            $entries = $request->data; //input('data');
            $entry = current($entries);
            $this->data = $entry;
            if ($this->getAction() == self::ACTION_EDIT || $this->getAction() == self::ACTION_REMOVE) {
                $ids = ($request->route('id') ? $request->route('id') : key($entries));
                $this->primary_key = formatEditorPrimaryKey($ids);
            }
        }
    }

    /**
     * Sets the rules for this given model
     *
     * @return array
     */
    abstract protected function setRules(array $rules = []);

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $data = null;
            if ($this->isValid()) {
                $data = $this->create($request);
            }
            ($this->hasErrors() ? DB::rollback() : DB::commit());
            return response()->json($this->output($data));
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
                //$response['traceArray'] =  $ex->getTrace();
                //dd($response);
                $response['trace'] = $ex->getTraceAsString(); //Array Trace Doesn't work with aJax
            }
            return response()->json($response);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function create(Request $request) {
        $class = $this->getPrimaryClass();
        $object = new $class();
        $data = $this->data[$object->getTable()];
        $object->fill($data);
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        return $this->getRows($request, $object->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        DB::beginTransaction();
        try {
            $data = null;
            if ($this->isValid()) {
                $data = $this->edit($request);
            }
            ($this->hasErrors() ? DB::rollback() : DB::commit());
            return response()->json($this->output($data));
        } catch (Exception $ex) {
            DB::rollback();
            $response = ['error' => $ex->getMessage()];
            if (!app()->environment('production')) {
                $response['file'] = $ex->getFile();
                $response['line'] = $ex->getLine();
                $response['trace'] = $ex->getTraceAsString(); //Array Trace Doesn't work with aJax
            }
            return response()->json($response);
        }
    }

    /**
     * Update an existing item resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function edit(Request $request) {
        $class = $this->getPrimaryClass();
        $object = $class::findOrFail($this->primary_key);
        $data = $this->data[$object->getTable()];
        $object->fill($data);
        if (!$object->save()) {
            $this->setError('Failed to save the entry');
        }
        return $this->getRows($request, $object->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        DB::beginTransaction();
        try {
            if ($object = $this->isValid()) {
                $this->delete($object);
            }
            ($this->hasErrors() ? DB::rollback() : DB::commit());
            return response()->json($this->output([]));
        } catch (Exception $ex) {
            DB::rollback();
            $response = ['error' => $ex->getMessage()];
            if (!app()->environment('production')) {
                $response['file'] = $ex->getFile();
                $response['line'] = $ex->getLine();
                $response['trace'] = $ex->getTraceAsString(); //Array Trace Doesn't work with aJax
            }
            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    protected function delete($object) {
        if (!$object->delete()) {
            $this->setError('Failed to delete the entry');
        }
        return $object;
    }

    /**
     * Validates the incoming data against the models rules
     * TODO: Look into the Validator->mergeRules() method
     * @return boolean
     */
    protected function isValid() {
        if ($this->getAction() != self::ACTION_REMOVE) {
            $this->initRules();
            $validator = Validator::make($this->data, $this->getRules(), $this->getMessages());
            if ($validator->fails()) {
                $messages = $validator->messages();
                foreach (array_keys($this->rules) as $key) {
                    $message = $messages->first($key);
                    if (strlen($message) > 0) {
                        array_push($this->fieldErrors, ['name' => $key, 'status' => $message]);
                    }
                }
                return false;
            }
        } else {
            $class = $this->getPrimaryClass();
            if (is_null($class)) {
                /*
                 * No primary class has been set.
                 * Therefore the logic is custom and does not follow the current ruleset.
                 * Ignore the isValid() method and return true. Assuming that the custom logic for validation will be performed elsewhere
                 */
                return true;
            }
            $object = $class::findOrFail($this->primary_key);
            if ($relationhip = $object->isLinked()) {
                $this->setError('This record is linked to one or more ' . $relationhip);
                return false;
            } else {
                return $object;
            }
        }
        return true;
    }
    
    /**
     *
     * @param type $entries
     * @return type
     */
    protected function output($entries) {
        if ($this->hasError()) {
            //return ['error' => $this->getError()];
            $this->output["error"] = $this->getError();
            return $this->output;
        }
        if ($this->hasFieldErrors()) {
            $this->output["fieldErrors"] = $this->getFieldErrors();
            return $this->output;
            //return ['fieldErrors' => $this->getFieldErrors()];
        }
        if ($this->getAction() == self::ACTION_REMOVE) {
            //return $this->output; //$this->output is set to an empty array ([]). This is what is expected on output when the ation is set to remove
        } else {
            $json = [];
            if (!is_null($this->primary_class) && $entries instanceof $this->primary_class) {
                $json[] = $this->process($entries); //$json = array_merge(["DT_RowId" => "row_" . $entries->id], $this->format($entries));
            } else {
                foreach ($entries AS $entry) {
                    $json[] = $this->process($entry); //$json[] = array_merge(["DT_RowId" => "row_" . $entry->id], $this->format($entry));
                }
            }
            $this->output["data"] = $json;
        }

        $postOutput = $this->postProcessOutput();
        if (count($postOutput) > 0) {
            return array_merge($this->output, $postOutput);
        }
        return $this->output;
        //return ["data" => $json]; //[$this->process($data)]
    }

    /**
     * Add additional values to the output before it is sent back to the client.
     * This method is made to be overridden. EG: Query the database for 
     * higher level values, summing up totals of child entries etc..
     */
    protected function postProcessOutput() {
        return [];
    }

    /**
     * Check to see if this model has any errors
     *
     * @return type
     */
    protected function hasErrors() {
        return ($this->hasFieldErrors() || $this->hasError());
    }

    /**
     *
     * @param type $validation_class
     */
    protected function setValidationClass($validation_class) {
        $this->validation_class = $validation_class;
    }

    /**
     *
     * @return type
     * @throws VRException
     */
    protected function getValidationClass() {
        if (class_exists($this->validation_class)) { //::class
            return $this->validation_class;
        }
        throw new VRException("Please set the appropriate validation method");
    }

    /**
     * Check to see if this model has any field errors
     *
     * @return type
     */
    protected function hasFieldErrors() {
        return (count($this->fieldErrors) > 0);
    }

    /**
     *
     * @param array $excludedFields
     */
    protected function setExcludedFields($excludedFields) {
        $this->excludeFields = $excludedFields;
    }

    /**
     *
     * @return array
     */
    protected function getFieldErrors() {
        return $this->fieldErrors;
    }

    /**
     *
     * @return array
     */
    protected function getRules() {
        return $this->rules;
    }

    /**
     *
     * @param array $messages
     */
    protected function setMessages($messages = []) {
        if (count($messages) > 0) {
            $this->messages = array_merge($this->messages, $messages);
        }
    }

    /**
     *
     * @return array
     */
    protected function getMessages() {
        if (count($this->messages) === 0) {
            $this->setMessages();
        }
        return $this->messages;
    }

    /**
     * Initiate the rules to be used in validation
     */
    public function initRules() {
        $this->setRules();
    }

    /**
     * 
     * @param type $pk_column
     */
    public function setPrimaryKeyColumn($pk_column) {
        $this->pk_column = $pk_column;
    }

    /**
     * 
     * @param type $pk_column
     * @return type
     */
    public function getPrimaryKeyColumn($pk_column) {
        return $this->pk_column;
    }

    /**
     * 
     * @return string
     */
    public function getIncludedFields($key = null) {
        return (is_null($key) ? $this->includeFields : $this->includeFields[$key]);
    }

    /**
     * 
     * @param string $includeFields
     */
    public function setIncludedFields($includeFields) {
        $this->includeFields = array_merge($this->includeFields, $includeFields);
    }

    /**
     * Automatically takes mapped fields and excludes them when doing validation. This helps validate a field and set field errors on their map
     * 
     * @param string $mappedFields
     */
    public function setMappedFields($mappedFields) {
        $excludeFields = [];
        foreach ($mappedFields AS $arrayFields) {
            $excludeFields = array_merge($excludeFields, $arrayFields);
        }
        $this->setExcludedFields($excludeFields);
        $this->mappedFields = array_merge($this->mappedFields, $mappedFields);
    }

    /**
     * @return array
     */
    public function getExcludedFields() {
        return $this->excludeFields;
    }

}
