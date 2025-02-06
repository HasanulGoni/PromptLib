<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function savedPrompts()
    {
        return $this->belongsToMany(Prompt::class, 'prompt_user');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function isPremium()
    {
        return $this->subscription && $this->subscription->plan === 'premium' && $this->subscription->expires_at > now();
    }

    public function reportedPrompts()
    {
        return $this->hasMany(ReportedPrompt::class);
    }
}
