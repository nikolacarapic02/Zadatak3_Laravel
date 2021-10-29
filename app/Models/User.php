<?php

namespace App\Models;

use App\Transformers\UserTransformer;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const VERIFIED_USER = 'verified';
    const UNVERIFIED_USER = 'unverified';

    const ADMIN_USER = 'admin';
    const RECRUITER_USER = 'recruiter';
    const MENTOR_USER = 'mentor';

    public $transformer = UserTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'verified',
        'verification_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->role == User::ADMIN_USER;
    }

    public function isRecruiter()
    {
        return $this->role == User::RECRUITER_USER;
    }

    public static function generateVerificationToken()
    {
        return Str::random(40);
    }
}
