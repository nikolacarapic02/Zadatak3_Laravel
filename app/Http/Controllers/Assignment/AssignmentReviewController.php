<?php

namespace App\Http\Controllers\Assignment;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentReviewController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Assignment $assignment)
    {
        $reviews = $assignment->reviews;

        return $this->showAll($reviews);
    }

}
