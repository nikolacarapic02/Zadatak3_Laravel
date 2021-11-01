<?php

namespace App\Http\Controllers\Assignment;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class AssignmentMentorController extends ApiController
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
        $mentor = $assignment->mentor;

        if(empty($mentor))
        {
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showOne($mentor);
        }
    }

}
