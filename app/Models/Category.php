<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Task;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'categories';

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
