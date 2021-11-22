<?php

namespace App\Http\Controllers\Intern;

use App\Models\Group;
use App\Models\Intern;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\InternTransformer;
use Illuminate\Support\Facades\Storage;

class InternController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.InternTransformer::class)->only(['store', 'update']);
        $this->middleware('can:viewAll')->only('index');
        $this->middleware('can:view,intern')->only('show');
        $this->middleware('can:create')->only('store');
        $this->middleware('can:update,intern')->only('update');
        $this->middleware('can:delete,intern')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interns = Intern::all();

        if($interns->isEmpty())
        {
            return $this->singleResponse('There is no data!!');
        }
        else
        {
            return $this->showAll($interns);
        }
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
            'address' => 'required',
            'email' => 'required|email|unique:interns',
            'phone' => 'required',
            'cv' => 'required|mimes:rtf,txt,pdf,docx',
            'github' => 'required',
            'group_id' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['github'] = 'https://github.com/'.$data['github'];

        if(Group::all()->pluck('id')->contains($request->group_id))
        {

            $data['cv'] = $request->cv->store('');

            $intern = Intern::create($data);

            return $this->showOne($intern,201);

        }
        else
        {
            return $this->errorResponse('Group id is invalid, because there is no group with that id!!', 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Http\Response
     */
    public function show(Intern $intern)
    {
        return $this->showOne($intern);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Intern $intern)
    {
        $rules = [
            'name' => 'string',
            'city' => 'string',
            'address' => 'string',
            'phone' => 'string',
            'email' => 'email|unique:interns',
            'cv' => 'mimes: rtf, txt, pdf, docx',
            'group_id' => 'integer|min:0'
        ];

        $this->validate($request, $rules);

        if($request->has('name'))
        {
            $intern->name = $request->name;
        }

        if($request->has('city'))
        {
            $intern->city = $request->city;
        }

        if($request->has('address'))
        {
            $intern->address = $request->address;
        }

        if($request->has('email'))
        {
            $intern->email = $request->email;
        }

        if($request->has('phone'))
        {
            $intern->phone = $request->phone;
        }

        if($request->hasFile('cv'))
        {
            Storage::delete($intern->cv);

            $intern->cv = $request->cv->store('');
        }

        if($request->has('github'))
        {
            $intern->github = 'https://github.com/'.$request->github;
        }

        if($request->has('group_id'))
        {
            if(Group::all()->pluck('id')->contains($request->group_id))
            {
                $intern->group_id = $request->group_id;
            }
            else
            {
                return $this->errorResponse('Group id is invalid, because there is no group with that id!!', 422);
            }
        }

        if($intern->isClean())
        {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $intern->save();

        return $this->showOne($intern);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Http\Response
     */
    public function destroy(Intern $intern)
    {
        $intern->delete();

        Storage::delete($intern->cv);

        if(!empty($intern->reviews->pluck('id')->first()))
        {
            Review::where('intern_id', '=', $intern->id)->delete();
        }

        return $this->showOne($intern);
    }
}
