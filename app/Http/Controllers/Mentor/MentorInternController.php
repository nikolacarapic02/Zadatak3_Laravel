<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorInternController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mentor $mentor)
    {
        $interns = $mentor->interns;

        return $this->showAll($interns);
    }

}
