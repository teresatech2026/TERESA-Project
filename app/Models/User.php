<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'is_active',
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
}