<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Data extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'company_name',
        'designation'
    ];
}
