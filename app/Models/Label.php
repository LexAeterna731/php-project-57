<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'labels_tasks', 'label_id', 'task_id');
    }
}
