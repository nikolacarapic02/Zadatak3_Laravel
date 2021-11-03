<?php

namespace App\Http\Controllers\Intern;

use App\Models\Intern;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\InternTransformer;

class InternMentorController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Intern $intern)
    {
        $mentors = $intern->group->mentors;

        if($mentors->isEmpty())
        {
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showAll($mentors);
        }
    }

}
