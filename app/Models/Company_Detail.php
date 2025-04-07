<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company_Detail extends Model
{
    protected $table = 'company_details';

    protected $fillable = [
        'name'
    ];
}
