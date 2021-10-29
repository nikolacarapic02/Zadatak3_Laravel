<?php

namespace App\Http\Controllers\Intern;

use App\Models\Intern;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\InternTransformer;
use App\Transformers\ReviewTransformer;

class InternReviewController extends ApiController
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
    public function index(Intern $intern)
    {
        $reviews = $intern->reviews;

        return $this->showAll($reviews);
    }

}
