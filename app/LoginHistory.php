<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $table = 'admin_login_history';

    protected $fillable = [
        'user_id','last_login_ip', 'last_login_location', 'last_login_date_time','role_id',
    ];
}
