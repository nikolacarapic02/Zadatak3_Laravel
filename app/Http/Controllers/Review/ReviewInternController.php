<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewInternController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Review $review)
    {
        $intern = $review->intern;

        return $this->showOne($intern);
    }

}
