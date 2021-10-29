<?php

namespace App\Transformers;

use App\Models\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
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
    public function transform(Group $group)
    {
        return [
            'identifier' => (int)$group->id,
            'name' => (string)$group->name,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('groups.show', $group->id)
                ],
                [
                    'rel' => 'groups.mentors',
                    'href' => route('groups.mentors.index',$group->id)
                ],
                [
                    'rel' => 'groups.interns',
                    'href' => route('groups.interns.index',$group->id)
                ],
                [
                    'rel' => 'groups.assignments',
                    'href' => route('groups.assignments.index',$group->id)
                ]
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
