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
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'city' => 'required',
            'email' => 'required|email',
            'skype' => 'required'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $mentor = Mentor::create($data);

        User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => User::MENTOR_USER,
                'verified' => User::UNVERIFIED_USER
            ]
        );

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
