<?php

namespace App\Transformers;

use App\Models\Mentor;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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

    protected function checkUser(User $user)
    {
        if($user->role == User::MENTOR_USER)
        {
            $mentor = Mentor::where('email', '=', $user->email)->first();

            return ['rel' => 'mentor', 'href' => route('mentors.show', $mentor->id)];
        }
    }

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        if($user->role == User::MENTOR_USER)
        {
            $mentor = Mentor::where('email', '=', $user->email)->first();

            return [
                'identifier' => (int)$user->id,
                'name' => (string)$user->name,
                'email' => (string)$user->email,
                'password' => (string)$user->password,
                'isVerified' => (string)$user->verified,
                'role' => (string)$user->role,

                'links' => [
                    [
                        'rel' => 'self',
                        'href' => route('users.show', $user->id)
                    ],
                    [
                        'rel' => 'self.mentor',
                        'href' => route('mentors.show', $mentor->id)
                    ]
                ]
            ];
        }
        else
        {
            return [
                'identifier' => (int)$user->id,
                'name' => (string)$user->name,
                'email' => (string)$user->email,
                'password' => (string)$user->password,
                'isVerified' => (string)$user->verified,
                'role' => (string)$user->role,

                'links' => [
                    [
                        'rel' => 'self',
                        'href' => route('users.show', $user->id)
                    ]
                ]
            ];
        }
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
            'isVerified' => 'verified',
            'role' => 'role',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
            'verified' => 'isVerified',
            'role' => 'role',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
