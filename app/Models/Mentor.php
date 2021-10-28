<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Intern;
use App\Models\Review;
use App\Models\Assignment;
use App\Models\GroupMentor;
use App\Transformers\MentorTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mentor extends Model
{
    use HasFactory, SoftDeletes;

    public $transformer = MentorTransformer::class;

    protected $fillable = [
        'name',
        'city',
        'skype',
        'email',
        'group_id'
    ];

    protected $hidden = [
        'group_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function interns()
    {
        return $this->hasManyThrough(
            Intern::class,
            GroupMentor::class,
            'mentor_id',
            'group_id',
            'id',
            'group_id'
        );
    }
}
