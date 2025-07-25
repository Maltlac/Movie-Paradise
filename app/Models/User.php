<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'role'
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

    public function hasRole($role)
    {
        return $this->role == $role;
    }

    public function UserFilm(){
        return $this->belongsToMany(film::class,'film_user');
    }

    public function UserPersonne(){
        return $this->belongsToMany(Personnes::class);
    }

    public function UserSerie(){
        return $this->belongsToMany(series::class,'series_user');
    }

    public function UserFilmVue(){
        return $this->belongsToMany(film::class,'film_vue');
    }
    public function UserSerieVue(){
        return $this->belongsToMany(series::class,'series_vue');
    }

    public static function nbUser(){
        return User::count();
    }
}
