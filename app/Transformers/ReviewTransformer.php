<?php

namespace App\Transformers;

use App\Models\Review;
use League\Fractal\TransformerAbstract;

class ReviewTransformer extends TransformerAbstract
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
    public function transform(Review $review)
    {
        return [
            'identifier' => (int)$review->id,
            'advantages' => (string)$review->pros,
            'disadvantages' => (string)$review->cons,
            'assignment_id' => (int)$review->assignment_id,
            'mentor_id' => (int)$review->mentor_id,
            'intern_id' => (int)$review->intern_id,
            'creationDate' => (string)$review->created_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('reviews.show', $review->id)
                ],
                [
                    'rel' => 'reviews.mentors',
                    'href' => route('reviews.mentors.index',$review->id)
                ],
                [
                    'rel' => 'reviews.interns',
                    'href' => route('reviews.interns.index',$review->id)
                ],
                [
                    'rel' => 'reviews.assignments',
                    'href' => route('reviews.assignments.index',$review->id)
                ]
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'advantages' => 'pros',
            'disadvantages' => 'cons',
            'assignment_id' => 'assignment_id',
            'mentor_id' => 'mentor_id',
            'intern_id' => 'intern_id',
            'creationDate' => 'created_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'pros' => 'advantages',
            'cons' => 'disadvantages',
            'assignment_id' => 'assignment_id',
            'mentor_id' => 'mentor_id',
            'intern_id' => 'intern_id',
            'created_at' => 'creationDate'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
