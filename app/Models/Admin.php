<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['user_id', 'full_name', 'position', 'area_of_responsibility', 'contact_number'];

    public function user()       { return $this->belongsTo(User::class); }
    public function advisories() { return $this->hasMany(Advisory::class); }
}
