<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as Model;

class PersonalAccessToken extends Model
{
    protected $table = 'ogs_personal_access_tokens';
}