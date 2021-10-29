<?php

namespace App\Transformers;

use App\Models\Intern;
use League\Fractal\TransformerAbstract;

class InternTransformer extends TransformerAbstract
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
    public function transform(Intern $intern)
    {
        return [
            'identifier' => (int)$intern->id,
            'name' => (string)$intern->name,
            'city' => (string)$intern->city,
            'address' => (string)$intern->address,
            'email' => (string)$intern->email,
            'mobile_phone' => (string)$intern->phone,
            'CV' => (string)$intern->cv,
            'GitHub' => (string)$intern->github,
            'group_id' => (int)$intern->group_id,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('interns.show', $intern->id)
                ],
                [
                    'rel' => 'interns.groups',
                    'href' => route('interns.groups.index',$intern->id)
                ],
                [
                    'rel' => 'interns.mentors',
                    'href' => route('interns.mentors.index',$intern->id)
                ],
                [
                    'rel' => 'interns.assignments',
                    'href' => route('interns.assignments.index',$intern->id)
                ],
                [
                    'rel' => 'interns.reviews',
                    'href' => route('interns.reviews.index',$intern->id)
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
            'address' => 'address',
            'email' => 'email',
            'mobile_phone' => 'phone',
            'CV' => 'cv',
            'GitHub' => 'github',
            'group_id' => 'group_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'city' => 'city',
            'address' => 'address',
            'email' => 'email',
            'phone' => 'mobile_phone',
            'cv' => 'CV',
            'github' => 'GitHub',
            'group_id' => 'group_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
