<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorGroupController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,mentor')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mentor $mentor)
    {
        $groups = $mentor->groups;

        if($groups->isEmpty())
        {
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showAll($groups);
        }
    }

}
