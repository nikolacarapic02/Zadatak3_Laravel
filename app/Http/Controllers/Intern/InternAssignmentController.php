<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;

class InternAssignmentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Intern $intern)
    {
        $assignments = $intern->group->assignments;

        return $this->showAll($assignments);
    }

}
