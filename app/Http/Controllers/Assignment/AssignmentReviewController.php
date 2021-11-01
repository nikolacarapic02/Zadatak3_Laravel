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
        $this->middleware('client.credentials')->only(['index']);
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
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showAll($reviews);
        }
    }

}
