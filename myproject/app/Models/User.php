<?php

// This is the User model which represents the users of the application. It extends the Authenticatable class provided by Laravel, allowing it to be used for authentication purposes. The model includes various attributes such as name, email, password, phone, role, and preferences. It also defines relationships to the Ride and Favorite models, indicating that a user can have many rides and favorites.
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Favorite;
use App\Models\Ride;

class User extends Authenticatable
{
    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // Role constants
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'preferences',
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
            'preferences' => 'array',
        ];
    }

    //Helper method
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Define relationships to rides
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    // Define relationship to favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
