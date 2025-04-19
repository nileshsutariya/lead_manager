<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Login extends Authenticatable
{
    use  HasFactory;

    protected $table = 'logins';

    protected $primaryKey = 'id';

    protected $fillable = [
        'password',
        'email',
    ];
    // public function getAuthIdentifierName()
    // {
    //     return 'email';
    // }

    // public function getAuthIdentifier()
    // {
    //     return $this->email; 
    // }
    protected $guard = 'admin';

    // public function getFullNameAttribute()
    // {
    //     return $this->name;
    // }
}
