<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupInternController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $interns = $group->interns;

        return $this->showAll($interns);
    }

}
