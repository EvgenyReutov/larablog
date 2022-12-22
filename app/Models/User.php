<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Watson\Rememberable\Rememberable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, Rememberable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function getCacheKey(int $userId): string
    {
        return 'user_' . $userId;
    }

    protected static function booted()
    {
        static::updated(function($user) {

            Cache::forget(static::getCacheKey($user->id));
            Cache::put(static::getCacheKey($user->id), $user);
        });
        static::created(function($user) {

            Cache::forget(static::getCacheKey($user->id));
            Cache::put(static::getCacheKey($user->id), $user);
        });
        static::deleted(function($user) {

            Cache::forget(static::getCacheKey($user->id));
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->using(RoleUser::class);
    }

    public function isAdmin()
    {
        $result = false;
        $roles = $this->roles()->get();

        if ($roles->count()) {
            foreach ($roles as $role) {
                if ($role->title === 'Admin') {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
