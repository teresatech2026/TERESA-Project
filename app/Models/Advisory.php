<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advisory extends Model
{
    protected $fillable = [
        'admin_id', 'title', 'content', 'category', 'image_path',
        'date_published', 'prepared_by', 'position', 'area_of_responsibility',
    ];

    protected $casts = ['date_published' => 'date'];

    public function admin() { return $this->belongsTo(Admin::class); }

    public function images() { return $this->hasMany(AdvisoryImage::class)->orderBy('sort_order'); }
}