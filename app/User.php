<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property string email
 * @property string password
 */

/**
 * @OA\Schema(
 *     required={"email", "password"},
 *     type="object",
 *     schema="User",
 * ),
 *     @OA\Property(
 *          property="email",
 *          type="string",
 *          description="Your Email",
 *          example="a@a.com"
 *    ),
 *     @OA\Property(
 *          property="password",
 *          type="string",
 *          description="Your password",
 *          example="test1234"
 *    ),
 *
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
