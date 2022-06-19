<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'twitter',
        'sendegate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'avatar',
        'avatar_tiny',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class)->withTimestamps()->withPivot('shiftrole_id');
    }

    protected function defaultProfilePhotoUrl()
    {
        return "/avatar.png";
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles->pluck('name')->toArray());
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getAvatarTinyAttribute()
    {
        $path = explode('/', $this->profile_photo_url);
        if (count($path) > 2)
            return "/storage/tiny/logos/" . $path[array_key_last($path)];
        
        return "/avatar.png";
    }

    public function getAvatarAttribute()
    {
        $path = explode('/', $this->profile_photo_url);
        if (count($path) > 2)
            return "/storage/big/logos/" . $path[array_key_last($path)];
        
        return "/avatar.png";
    }
}
