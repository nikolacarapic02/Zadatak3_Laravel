<?php

namespace App\Http\Controllers\Mentor;

use App\Models\Group;
use App\Models\Mentor;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\AssignmentTransformer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MentorAssignmentController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('transform.input:'.AssignmentTransformer::class)->only(['store', 'update']);
        $this->middleware('can:view,mentor')->only('index');
        $this->middleware('can:update,mentor')->only('update');
        $this->middleware('can:delete,mentor')->only('destroy');
        $this->middleware('can:createAssignmentReview,mentor')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mentor $mentor)
    {
        $assignments = $mentor->assignments;

        if($assignments->isEmpty())
        {
            return $this->showMessage('There is no data!!');
        }
        else
        {
            return $this->showall($assignments);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Mentor $mentor)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'group_id' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $data['mentor_id'] = $mentor->id;
        $data['status'] = Assignment::INACTIVE_ASSIGNMENT;

        if($mentor->groups->pluck('id')->contains($data['group_id']))
        {
            $assignment = Assignment::create($data);

            return $this->showOne($assignment);
        }
        else
        {
            return $this->errorResponse('This mentor cannot set assignment for this group!!', 409);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mentor $mentor, Assignment $assignment)
    {
        $rules = [
            'name' => 'string',
            'description' => 'string',
            'group_id' => 'integer|min:1',
            'status' => 'string|in:' . Assignment::INACTIVE_ASSIGNMENT
        ];

        $this->validate($request, $rules);

        $this->checkMentor($mentor, $assignment);

        if($request->has('name'))
        {
            $assignment->name = $request->name;
        }

        if($request->has('description'))
        {
            $assignment->description = $request->description;
        }

        if($request->has('group_id'))
        {
            $this->checkGroup($mentor, $request);

            $assignment->group_id = $request->group_id;
        }

        if($assignment->status == Assignment::INACTIVE_ASSIGNMENT)
        {
            if($request->has('status') || $request->has('start_date') || $request->has('finish_date'))
            {
                return $this->errorResponse('Fields status, start_date, end_date cannot be updated, until they are activated in the group!!', 422);
            }
        }

        if($request->has('status'))
        {
            $assignment->status = $request->status;

            $assignment->start_date = null;

            $assignment->finish_date = null;
        }

        if($request->has('start_date'))
        {
            return $this->errorResponse('Start date cannot be updated!!', 422);
        }

        if($request->has('finish_date'))
        {
            if($request->finish_date < $assignment->start_date)
            {
                return $this->errorResponse('Finish date must be after start date!!',422);
            }
            else
            {
                $assignment->finish_date = $request->finish_date;
            }
        }

        if($assignment->isClean())
        {
            return $this->errorResponse('You need to specify a different value to update!!',422);
        }

        $assignment->save();

        return $this->showOne($assignment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mentor $mentor, Assignment $assignment)
    {
        $this->checkMentor($mentor, $assignment);

        if($assignment->reviews->pluck('id')->isEmpty())
        {
            $assignment->delete();
            return $this->showOne($assignment);
        }
        else
        {
            return $this->errorResponse('You cannot delete assignment, because this assignment contains other values!!', 409);
        }
    }

    protected function checkMentor(Mentor $mentor, Assignment $assignment)
    {
        if ($mentor->id != $assignment->mentor_id) {
            throw new HttpException(422, 'Assignment does not belong to this mentor!!');
        }
    }

    protected function checkGroup(Mentor $mentor, Request $request)
    {
        if($mentor->groups->contains($request->group_id) != true)
        {
            throw new HttpException(422, 'Group id is invalid, because the mentor does not belong to this group!!');
        }
    }

    public function clone($mentor_id, $assignment_id, $group_id)
    {
        $assignment = Assignment::where('id', '=', $assignment_id)->firstOrFail();

        $group = Group::where('id', '=', $group_id)->firstOrFail();

        if($group->mentors()->pluck('id')->contains($mentor_id))
        {
            if($group->assignments()->pluck('description')->contains($assignment->description))
            {
                return $this->errorResponse('The assignment is already in the selected group!!',409);
            }
            else
            {
                $new_assignment = Assignment::create([
                    'name' => $assignment->name,
                    'description' => $assignment->description,
                    'status' => Assignment::INACTIVE_ASSIGNMENT,
                    'group_id' => $group->id,
                    'mentor_id' => $mentor_id
                ]);

                return $this->showOne($new_assignment);
            }
        }
        else
        {
            return $this->errorResponse('This mentor cannot clone assignment to this group, because the mentor is not a part of this group!!',409);
        }

    }
}
