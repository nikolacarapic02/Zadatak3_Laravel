<?php

namespace App\Http\Controllers\Mentor;

use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\ReviewTransformer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MentorInternReviewController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'. ReviewTransformer::class)->only(['store', 'update']);
        $this->middleware('can:update,mentor')->only('update');
        $this->middleware('can:delete,mentor')->only('destroy');
        $this->middleware('can:createAssignmentReview,mentor')->only('store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Mentor $mentor, Intern $intern)
    {
        $rules = [
            'pros' => 'required',
            'cons' => 'required',
            'assignment_id' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $data['mentor_id'] = $mentor->id;
        $data['intern_id'] = $intern->id;

        if($mentor->groups->pluck('id')->contains($intern->group_id))
        {
            if($mentor->assignments->pluck('id')->contains($data['assignment_id']))
            {
                $review = Review::create($data);

                return $this->showOne($review);
            }
            else
            {
                return $this->errorResponse('This mentor cannot leave review for this assignment!!', 409);
            }
        }
        else
        {
            return $this->errorResponse('This mentor is not a mentor from this intern!!', 409);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mentor $mentor, Intern $intern, Review $review)
    {
        $rules = [
            'pros' => 'string',
            'cons' => 'string',
            'assignment_id' => 'integer|min:1',
            'mentor_id' => 'integer|min:1',
            'intern_id' => 'integer|min:1'
        ];

        $this->validate($request, $rules);

        $this->checkMentor($mentor, $review);

        if($request->has('pros'))
        {
            $review->pros = $request->pros;
        }

        if($request->has('cons'))
        {
            $review->cons = $request->cons;
        }

        if($request->has('mentor_id'))
        {
            return $this->errorResponse('Mentor id cannot be changed!!', 422);
        }

        if($request->has('intern_id'))
        {
            return $this->errorResponse('Intern id cannot be changed!!', 422);
        }

        if($request->has('assignment_id'))
        {
            $this->checkAssignment($mentor, $request);

            $this->checkIntern($intern, $request);

            $review->assignment_id = $request->assignment_id;
        }

        if($review->isClean())
        {
            return $this->errorResponse('You need to specify a different value to update!!',422);
        }

        $review->save();

        return $this->showOne($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mentor $mentor, Intern $intern, Review $review)
    {
        $this->checkMentor($mentor, $review);

        $review->delete();

        return $this->showOne($review);
    }

    protected function checkMentor(Mentor $mentor, Review $review)
    {
        if ($mentor->id != $review->mentor_id) {
            throw new HttpException(422, 'Review does not belong to this mentor!!');
        }
    }

    protected function checkAssignment(Mentor $mentor, Request $request)
    {
        if($mentor->assignments->contains($request->assignment_id) != true)
        {
            throw new HttpException(422, 'Assignment id is invalid, because the mentor does not make this assignment!!');
        }
    }

    protected function checkIntern(Intern $intern, Request $request)
    {
        if($intern->group->assignments->contains($request->assignment_id) != true)
        {
            throw new HttpException(422, 'Assignment id is invalid, because the intern does not have this assignment!!');
        }
    }

}
