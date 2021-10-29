<?php

namespace App\Http\Controllers\Mentor;

use App\Models\User;
use App\Models\Group;
use App\Models\Mentor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\MentorTransformer;

class MentorController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:'.MentorTransformer::class)->only(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentors = Mentor::all();

        return $this->showAll($mentors);
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
            'email' => 'email',
            'skype' => 'string'
        ];

        $this->validate($request, $rules);

        $user = User::where('name', '=', $mentor->name)->first();

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
            $user->email = $user->email;
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
