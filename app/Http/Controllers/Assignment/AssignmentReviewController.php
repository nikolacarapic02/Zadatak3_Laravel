<?php

namespace App\Http\Controllers\Assignment;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class AssignmentReviewController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,assignment')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Assignment $assignment)
    {
        $reviews = $assignment->reviews;

        if($reviews->isEmpty())
        {
            return $this->singleResponse('There is no data!!');
        }
        else
        {
            return $this->showAll($reviews);
        }
    }

}
