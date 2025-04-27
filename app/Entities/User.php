<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    protected $attributes = [
        'username' => null,
        'email'    => null,
        'password' => null,
        // Add other user attributes here
    ];
}
