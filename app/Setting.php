<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Setting extends Model
{
    protected $table = 'setting';

     protected $fillable = [
        'company_name', 'company_phone', 'company_email','company_address','company_logo','company_fav',
    ];

    

}
