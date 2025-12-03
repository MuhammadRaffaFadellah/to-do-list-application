<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Important extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'importants';

    public function tasks() {
        return $this->hasMany(Task::class, 'is_important');
    }
}
