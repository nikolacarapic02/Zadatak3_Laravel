<?php

namespace App\Http\Controllers\Group;

use App\Models\Group;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Transformers\GroupTransformer;
use App\Transformers\AssignmentTransformer;
use App\Http\Controllers\ApiController;

class GroupAssignmentController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('transform.input:'.AssignmentTransformer::class)->only(['activate']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $assignments = $group->assignments;

        return $this->showAll($assignments);
    }

    public function activate($group_id, $assignment_id, Request $request)
    {
        $rules = [
            'finish_date' => 'date'
        ];

        $this->validate($request, $rules);

        $assignment = Assignment::where('id', '=', $assignment_id)->where('group_id', '=', $group_id)->firstOrFail();

        $assignment->status = Assignment::ACTIVE_ASSIGNMENT;

        $assignment->start_date = Carbon::now();

        if($request->has('finish_date'))
        {
            if($request->finish_date > $assignment->start_date)
            {
                $assignment->finish_date = $request->finish_date;
            }
            else
            {
                return $this->errorResponse('Assignment finishDate must be after startDate!!', 409);
            }
        }
        else
        {
            return $this->errorResponse('You must specified a finishDate for assignment!!',409);
        }

        $assignment->save();

        return $this->showOne($assignment);
    }

}
