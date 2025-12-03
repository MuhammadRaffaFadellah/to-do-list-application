<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Status;
use App\Models\Important;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'is_important',
        'status_id',
    ];

    protected $table = 'tasks';

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function important(){
        return $this->belongsTo(Important::class, 'is_important');
    }
}
