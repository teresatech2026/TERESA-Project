<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'type', 'title', 'content', 'is_read'];

    public function user() { return $this->belongsTo(User::class); }
}
