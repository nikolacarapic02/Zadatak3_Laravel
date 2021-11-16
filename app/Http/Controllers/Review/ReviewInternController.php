<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewInternController extends ApiController
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
        $intern = $review->intern;

        if(empty($intern))
        {
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showOne($intern);
        }
    }

}
