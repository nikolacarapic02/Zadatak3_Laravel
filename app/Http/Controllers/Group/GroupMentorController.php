<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupMentorController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $mentors = $group->mentors;

        return $this->showAll($mentors);
    }

}
