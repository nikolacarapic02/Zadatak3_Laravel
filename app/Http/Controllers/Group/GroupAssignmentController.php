<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupAssignmentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $assignments = $group->assignments;

        return $this->showAll($assignments);
    }

}
