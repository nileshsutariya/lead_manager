<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'mail_templet'
    ];

    // public function emails()
    // {
    //     return $this->hasMany(Email::class);
    // }
}
