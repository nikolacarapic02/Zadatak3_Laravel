<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Review;
use App\Transformers\InternTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intern extends Model
{
    use HasFactory, SoftDeletes;

    public $transformer = InternTransformer::class;

    protected $fillable = [
        'name',
        'city',
        'address',
        'email',
        'phone',
        'cv',
        'github',
        'group_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'laravel_through_key'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
