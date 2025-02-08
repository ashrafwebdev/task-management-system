<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSession extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'start_time', 'end_time'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
