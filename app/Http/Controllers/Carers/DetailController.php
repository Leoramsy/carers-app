<?php

namespace App\Http\Controllers\Carers;

use App\Http\Controllers\EditorController;
use App\Http\Controllers\type;
use App\Models\Carers\Detail;
use Illuminate\Http\Request;

class DetailController extends EditorController
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        //
    }


    protected function format($entry)
    {
        // TODO: Implement format() method.
    }

    protected function setRules(array $rules = [])
    {
        // TODO: Implement setRules() method.
    }
}
