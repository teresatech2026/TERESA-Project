<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'type', 'title', 'content', 'url', 'is_read', 'created_at'];
    protected $casts = ['created_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }

    /**
     * Convenience method to create a notification for a given user.
     */
    public static function notify(int $userId, string $type, string $title, ?string $content = null, ?string $url = null): self
{
    return static::create([
        'user_id' => $userId,
        'type' => $type,
        'title' => $title,
        'content' => $content,
        'url' => $url,
        'is_read' => false,
        'created_at' => now(),
    ]);
}
}