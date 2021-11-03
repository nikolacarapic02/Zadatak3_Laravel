<?php

namespace App\Http\Controllers\Mentor;

use App\Models\Mentor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class MentorReviewController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('can:view,mentor')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mentor $mentor)
    {
        $reviews = $mentor->reviews;

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
