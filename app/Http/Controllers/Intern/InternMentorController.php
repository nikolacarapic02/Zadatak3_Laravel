<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;

class InternMentorController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Intern $intern)
    {
        $mentors = $intern->group->mentors;

        return $this->showAll($mentors);
    }

}
