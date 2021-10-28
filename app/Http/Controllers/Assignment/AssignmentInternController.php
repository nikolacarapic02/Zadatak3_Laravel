<?php

namespace App\Http\Controllers\Assignment;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentInternController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Assignment $assignment)
    {
        $interns = $assignment->group->interns;

        return $this->showAll($interns);
    }

}
