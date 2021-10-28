<?php

namespace App\Models;

use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Assignment;
use App\Transformers\ReviewTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    public $transformer = ReviewTransformer::class;

    protected $fillable = [
        'pros',
        'cons',
        'assignment_id',
        'mentor_id',
        'intern_id'
    ];

    protected $hidden = [
        'mentor_id',
        'updated_at',
        'deleted_at'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
