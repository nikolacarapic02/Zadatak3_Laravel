<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Mentor;
use App\Models\Review;
use App\Mail\UserCreated;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only('resend');
        $this->middleware('auth:api')->except('verify', 'resend');
        $this->middleware('transform.input:'.UserTransformer::class)->only('store', 'update');
        $this->middleware('can:admin-action')->only('index', 'update', 'destroy', 'changeRole');
        $this->middleware('can:create')->only('store');
        $this->middleware('can:view,user')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        if($users->isEmpty())
        {
            return $this->singleResponse('There is no data!!');
        }
        else
        {
            return $this->showAll($users);
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationToken();
        $data['role'] = User::MENTOR_USER;

        $user = User::create($data);

        Mentor::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'city' => '',
                'skype' => null
            ]
        );

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'string',
            'email' => 'email|unique:users',
            'password' => 'min:6'
        ];

        $this->validate($request, $rules);

        if($user->role == User::MENTOR_USER)
        {
           $mentor = Mentor::where('email', '=', $user->email)->first();
        }

        if($request->has('name'))
        {
            if($user->role == User::MENTOR_USER)
            {
                $user->name = $request->name;
                $mentor->name = $request->name;
            }
            else
            {
                $user->name = $request->name;
            }
        }

        if ($request->has('email') && $user->email != $request->email)
        {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationToken();
            $user->email = $request->email;

            if($user->role == User::MENTOR_USER)
            {
                $mentor->email = $user->email;
            }
        }

        if ($request->has('password'))
        {
            $user->password = bcrypt($request->password);
        }

        if($user->isClean())
        {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        if($user->role == User::MENTOR_USER)
        {
            $user->save();

            $mentor->save();
        }
        else
        {
            $user->save();
        }

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->role == 'mentor')
        {
            $mentor = Mentor::where('email', '=', $user->email)->first();

            $user->delete();
            $mentor->groups()->sync([]);

            if(!$mentor->assignments->isEmpty())
            {
                Assignment::where('mentor_id', '=', $mentor->id)->delete();
            }

            if(!$mentor->reviews->isEmpty())
            {
                Review::where('mentor_id', '=', $mentor->id)->delete();
            }

            $mentor->delete();
        }
        else
        {
            $user->delete();
        }

        return $this->singleResponse('User deleted successfully', 200);
    }

    public function verify($token)
    {
        $user = User::where('verification_token', '=', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('The account has been verified succesfully');
    }

    public function resend(User $user)
    {
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified', 409);
        }

        retry(5, function() use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            }, 100);

        return $this->showMessage('The verification email has been resend');
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return $this->showOne($user);
    }

    public function changeRole(Request $request, User $user)
    {
        $rules = [
            'role' => 'in:' . User::ADMIN_USER . ',' . User::RECRUITER_USER . ',' . User::MENTOR_USER
        ];

        $this->validate($request, $rules);

        if($request->has('role'))
        {
            if($user->role == $request->role)
            {
                return $this->errorResponse('You need to specify a different value to update', 422);
            }
            else
            {
                if($request->role == 'mentor')
                {
                    $mentor = Mentor::create(
                        [
                            'name' => $user->name,
                            'email' => $user->email,
                            'city' => '',
                            'skype' => null
                        ]
                    );

                    $user->role = $request->role;
                }
                else
                {
                    $user->role = $request->role;

                    $mentor = Mentor::where('email', '=', $user->email)->first();

                    $mentor->groups()->sync([]);

                    $mentor->delete();

                }
            }
        }

        $user->save();

        return $this->showOne($user);
    }
}
