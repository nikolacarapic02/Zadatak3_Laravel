<?php

namespace App\Models;

use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Assignment;
use App\Transformers\GroupTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    public $transformer = GroupTransformer::class;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class);
    }

    public function interns()
    {
        return $this->hasMany(Intern::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
