<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupMentor extends Pivot
{
    use HasFactory;

    protected $table = 'group_mentor';
}
