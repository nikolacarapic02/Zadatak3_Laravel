<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAssignmentController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,review')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Review $review)
    {
        $assignment = $review->assignment;

        if(empty($assignment))
        {
            return $this->singleResponse('There is no data!!');
        }
        else
        {
            return $this->showOne($assignment);
        }
    }

}
