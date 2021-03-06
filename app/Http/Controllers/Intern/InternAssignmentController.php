<?php

namespace App\Http\Controllers\Intern;

use App\Models\Intern;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Models\Assignment;

class InternAssignmentController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,intern')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Intern $intern)
    {
        $assignments = $intern->group->assignments;

        if($assignments->isEmpty())
        {
            return $this->singleResponse('There is no data!!');
        }
        else
        {
            return $this->showAll($assignments->where('status', '=', Assignment::ACTIVE_ASSIGNMENT));
        }
    }

}
