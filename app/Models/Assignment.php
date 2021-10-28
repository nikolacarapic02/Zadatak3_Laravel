<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Review;
use App\Transformers\AssignmentTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    const ACTIVE_ASSIGNMENT = 'active';
    const INACTIVE_ASSIGNMENT = 'inactiv';

    public $transformer = AssignmentTransformer::class;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'finish_date',
        'status',
        'group_id',
        'mentor_id'
    ];

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function isActive()
    {
        return $this->status == Assignment::ACTIVE_ASSIGNMENT;
    }
}
