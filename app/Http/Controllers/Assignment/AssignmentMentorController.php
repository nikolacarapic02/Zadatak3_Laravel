<?php

namespace App\Http\Controllers\Assignment;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentMentorController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Assignment $assignment)
    {
        $mentor = $assignment->mentor;

        return $this->showOne($mentor);
    }

}
