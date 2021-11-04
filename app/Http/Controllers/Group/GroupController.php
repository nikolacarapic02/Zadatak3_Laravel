<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Mentor;
use App\Transformers\GroupTransformer;
use Illuminate\Http\Request;

class GroupController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('transform.input:'.GroupTransformer::class)->only(['store', 'update']);
        $this->middleware('can:view,group')->only('show');
        $this->middleware('can:create')->only('store');
        $this->middleware('can:update,group')->only('update', 'addMentor', 'deleteMentor');
        $this->middleware('can:delete,group')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();

        if($groups->isEmpty())
        {
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showAll($groups);
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
            'name' => 'required'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $group = Group::create($data);

        return $this->showOne($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return $this->showOne($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $rules = [
            'name' => 'string'
        ];

        $this->validate($request, $rules);

        if($request->has('name'))
        {
            $group->name = $request->name;
        }

        if($group->isClean())
        {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $group->save();

        return $this->showOne($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if($group->interns->pluck('id')->isEmpty() && $group->mentors->pluck('id')->isEmpty() && $group->assignments->pluck('id')->isEmpty())
        {
            $group->delete();
            return $this->showOne($group);
        }
        else
        {
            return $this->errorResponse('You cannot delete group, because this group contains other values!!', 409);
        }

    }

    public function addMentor(Request $request, $group_id)
    {
        $rules = [
            'mentor_id' => 'integer|min:1'
        ];

        $this->validate($request, $rules);

        $group = Group::where('id', '=', $group_id)->first();

        if($group->mentors->pluck('id')->contains($request->mentor_id))
        {
            return $this->errorResponse('The mentor is already in the group!!', 409);
        }

        if($request->has('mentor_id'))
        {
            if(Mentor::all()->contains($request->mentor_id))
            {
                $group->mentors()->attach($request->mentor_id);
            }
            else
            {
                return $this->errorResponse('This mentor_id does not exist!!', 409);
            }
        }
        else
        {
            return $this->errorResponse('You need to specify mentor_id!!', 409);
        }

        return $this->showMessage('Mentor with id ' . $request->mentor_id . ' was successfully added to the group.');
    }

    public function deleteMentor(Request $request, $group_id)
    {
        $rules = [
            'mentor_id' => 'integer|min:1'
        ];

        $this->validate($request, $rules);

        $group = Group::where('id', '=', $group_id)->first();

        if(!$group->mentors->pluck('id')->contains($request->mentor_id))
        {
            return $this->errorResponse('There is no mentor in the group with this id!!', 409);
        }

        if($request->has('mentor_id'))
        {
            if(Mentor::all()->contains($request->mentor_id))
            {
                $group->mentors()->detach($request->mentor_id);
            }
            else
            {
                return $this->errorResponse('This mentor_id does not exist!!', 409);
            }
        }
        else
        {
            return $this->errorResponse('You need to specify mentor_id!!', 409);
        }

        return $this->showMessage('Mentor with id ' . $request->mentor_id . ' was successfully deleted from the group.');
    }
}
