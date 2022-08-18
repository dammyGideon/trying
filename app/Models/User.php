<?php

namespace App\Models;

use App\Mail\Forgotpassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use Spatie\Permission\Traits\HasRoles;
use App\Models\wallet;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;



    /**
     * @var mixed|string
     *
     *
     *
     * 
     */


    protected $fillable = [
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $url=$token;
        $this->notify(new ResetPasswordNotification($url));
    }


}
