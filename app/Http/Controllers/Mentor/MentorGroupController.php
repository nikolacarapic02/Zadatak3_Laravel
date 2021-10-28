<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorGroupController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mentor $mentor)
    {
        $groups = $mentor->groups;

        return $this->showAll($groups);
    }

}
