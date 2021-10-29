<?php

namespace App\Transformers;

use App\Models\Mentor;
use League\Fractal\TransformerAbstract;

class MentorTransformer extends TransformerAbstract
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
    public function transform(Mentor $mentor)
    {
        return [
            'identifier' => (int)$mentor->id,
            'name' => (string)$mentor->name,
            'city' => (string)$mentor->city,
            'email' => (string)$mentor->email,
            'skype' => (string)$mentor->skype,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('mentors.show', $mentor->id)
                ],
                [
                    'rel' => 'mentors.groups',
                    'href' => route('mentors.groups.index',$mentor->id)
                ],
                [
                    'rel' => 'mentors.interns',
                    'href' => route('mentors.interns.index',$mentor->id)
                ],
                [
                    'rel' => 'mentors.assignments',
                    'href' => route('mentors.assignments.index',$mentor->id)
                ],
                [
                    'rel' => 'mentors.reviews',
                    'href' => route('mentors.reviews.index', $mentor->id)
                ]
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'city' => 'city',
            'email' => 'email',
            'skype' => 'skype'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'city' => 'city',
            'email' => 'email',
            'skype' => 'skype'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
