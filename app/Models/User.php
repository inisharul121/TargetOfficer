<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'target_exam',
        'avatar',
        'coins',
        'daily_streak',
        'longest_streak',
        'last_active_date',
        'preferred_language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_active_date' => 'date',
            'password' => 'hashed',
            'coins' => 'integer',
            'daily_streak' => 'integer',
            'longest_streak' => 'integer',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSetter(): bool
    {
        return in_array($this->role, ['admin', 'setter']);
    }

    public function examAttempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')->withPivot('awarded_at');
    }

    public function updateStreak(): void
    {
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        if ($this->last_active_date?->toDateString() === $today) {
            return;
        }

        if ($this->last_active_date?->toDateString() === $yesterday) {
            $this->daily_streak += 1;
        } else {
            $this->daily_streak = 1;
        }

        if ($this->daily_streak > $this->longest_streak) {
            $this->longest_streak = $this->daily_streak;
        }

        $this->last_active_date = $today;
        $this->save();
    }
}
