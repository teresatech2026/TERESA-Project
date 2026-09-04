<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvisoryImage extends Model
{
    protected $fillable = ['advisory_id', 'image_path', 'sort_order'];

    public function advisory()
    {
        return $this->belongsTo(Advisory::class);
    }
}