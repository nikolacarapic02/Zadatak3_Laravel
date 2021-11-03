<?php

namespace App\Http\Controllers\Assignment;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class AssignmentGroupController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('can:view,assignment')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Assignment $assignment)
    {
        $group = $assignment->group;

        if(empty($group))
        {
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showOne($group);
        }
    }
}
