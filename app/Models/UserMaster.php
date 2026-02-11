<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserMaster extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'res_user_master';
    protected $primaryKey = 'userid';

    protected $fillable = [
        'userloginid',
        'userpassword',
        'userrole',
        'userfname',
        'userlname',
        'email',
        'mobile',
        'address'
    ];

    protected $hidden = [
        'userpassword'
    ];

    public function getAuthPassword()
    {
        return $this->userpassword;
    }

}
