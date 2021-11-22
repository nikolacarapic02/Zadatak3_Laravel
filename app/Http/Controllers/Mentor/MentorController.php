<?php

namespace App\Http\Controllers\Mentor;

use App\Models\User;
use App\Models\Mentor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\MentorTransformer;

class MentorController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.MentorTransformer::class)->only(['update']);
        $this->middleware('can:viewAll')->only('index');
        $this->middleware('can:view,mentor')->only('show');
        $this->middleware('can:updateMentor,mentor')->only('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentors = Mentor::all();

        if($mentors->isEmpty())
        {
            return $this->singleResponse('There is no data!!');
        }
        else
        {
            return $this->showAll($mentors);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mentor $mentor)
    {
        $rules = [
            'name' => 'string',
            'city' => 'string',
            'email' => 'email|unique:mentors',
            'skype' => 'string'
        ];

        $this->validate($request, $rules);

        $user = User::where('email', '=', $mentor->email)->first();

        if($request->has('name'))
        {
            $mentor->name = $request->name;
            $user->name = $request->name;
        }

        if($request->has('city'))
        {
            $mentor->city = $request->city;
        }

        if($request->has('skype'))
        {
            $mentor->skype = $request->skype;
        }

        if($request->has('email'))
        {
            $mentor->email = $request->email;
            $user->email = $request->email;
        }

        if($mentor->isClean())
        {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $mentor->save();
        $user->save();

        return $this->showOne($mentor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function show(Mentor $mentor)
    {
        return $this->showOne($mentor);
    }

}
