<?php

namespace App\Http\Controllers\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class GroupInternController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,group')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $interns = $group->interns;

        if($interns->isEmpty())
        {
            return $this->singleResponse('There is no data!!');
        }
        else
        {
            return $this->showAll($interns);
        }
    }

}
