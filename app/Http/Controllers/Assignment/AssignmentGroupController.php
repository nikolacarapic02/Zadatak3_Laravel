<?php

namespace App\Http\Controllers\Assignment;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentGroupController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Assignment $assignment)
    {
        $group = $assignment->group;

        return $this->showOne($group);
    }
}
