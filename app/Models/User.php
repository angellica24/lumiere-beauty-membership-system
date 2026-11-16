<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'membership_level_id',
        'total_points',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'total_points' => 'integer',
    ];

    public function membershipLevel()
    {
        return $this->belongsTo(MembershipLevel::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole(string $role): bool
    {
        if ($this->relationLoaded('roles') && $this->roles->contains('name', $role)) {
            return true;
        }

        if ($this->roles()->where('name', $role)->exists()) {
            return true;
        }

        return $this->role === $role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }
}