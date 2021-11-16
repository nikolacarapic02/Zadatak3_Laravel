<?php

namespace App\Http\Controllers\Assignment;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class AssignmentController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:viewAll')->only('index');
        $this->middleware('can:view,assignment')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = Assignment::all();

        if($assignments->isEmpty())
        {
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showAll($assignments);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        return $this->showOne($assignment);
    }

}
