<?php

namespace App\Http\Controllers\Assignment;

use App\Models\Group;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\AssignmentTransformer;

class AssignmentGroupController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }

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
