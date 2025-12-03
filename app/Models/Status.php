<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Status extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'statuses';

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
