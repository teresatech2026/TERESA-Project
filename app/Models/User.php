<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

   protected $fillable = [
    'name',
    'username',
    'email',
    'password',
    'role',
    'google_id',
    'is_active',
    'profile_photo_path',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function farmer() { return $this->hasOne(Farmer::class); }
    public function buyer()  { return $this->hasOne(Buyer::class); }
    public function admin()  { return $this->hasOne(Admin::class); }
    public function notifications() { return $this->hasMany(Notification::class); }

    public function isFarmer(): bool { return $this->role === 'farmer'; }
    public function isBuyer(): bool  { return $this->role === 'buyer'; }
    public function isAdmin(): bool  { return $this->role === 'admin'; }

    /**
     * The URL of the user's profile photo, or null if they haven't set one.
     * Views should fall back to a generic avatar/initials when this is null.
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo_path
            ? Storage::disk('supabase')->url($this->profile_photo_path)
            : null;
    }
}