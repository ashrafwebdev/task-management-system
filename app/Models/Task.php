<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'assigned_to', 'status'];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function sessions()
    {
        return $this->hasMany(TaskSession::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(TaskStatusHistory::class);
    }
}
