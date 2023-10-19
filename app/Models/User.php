<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property integer $id
 * @property integer $id_rol
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $two_factor_secret
 * @property string $two_factor_recovery_codes
 * @property string $two_factor_confirmed_at
 * @property string $remember_token
 * @property integer $current_team_id
 * @property string $profile_photo_path
 * @property integer $enable
 * @property string $created_at
 * @property string $updated_at
 */

class User extends Authenticatable
{
    /**
     * @var array
     */
    protected $fillable = ['id_rol', 'name', 'email', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'remember_token', 'current_team_id', 'profile_photo_path', 'enable', 'created_at', 'updated_at'];
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
}
