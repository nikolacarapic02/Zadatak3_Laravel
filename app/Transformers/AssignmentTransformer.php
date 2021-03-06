<?php

namespace App\Transformers;

use App\Models\Assignment;
use League\Fractal\TransformerAbstract;

class AssignmentTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Assignment $assignment)
    {
        return [
            'identifier' => (int)$assignment->id,
            'title' => (string)$assignment->name,
            'details' => (string)$assignment->description,
            'startDate' => (string)$assignment->start_date,
            'finishDate' => (string)$assignment->finish_date,
            'status' => (string)$assignment->status,
            'group_id' => (int)$assignment->group_id,
            'mentor_id'=> (int)$assignment->mentor_id,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('assignments.show', $assignment->id)
                ],
                [
                    'rel' => 'assignments.groups',
                    'href' => route('assignments.groups.index',$assignment->id)
                ],
                [
                    'rel' => 'assignments.interns',
                    'href' => route('assignments.interns.index',$assignment->id)
                ],
                [
                    'rel' => 'assignments.mentors',
                    'href' => route('assignments.mentors.index',$assignment->id)
                ],
                [
                    'rel' => 'assignments.reviews',
                    'href' => route('assignments.reviews.index',$assignment->id)
                ]
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'title' => 'name',
            'details' => 'description',
            'startDate' => 'start_date',
            'finishDate' => 'finish_date',
            'status' => 'status',
            'group_id' => 'group_id',
            'mentor_id'=> 'mentor_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'title',
            'description' => 'details',
            'start_date' => 'stratDate',
            'finish_date' => 'finishDate',
            'status' => 'status',
            'group_id' => 'group_id',
            'mentor_id'=> 'mentor_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
