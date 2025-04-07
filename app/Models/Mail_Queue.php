<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mail_Queue extends Model
{
    protected $table = 'mail_queue';

    protected $fillable = [
        'user_emails',
        'attachment_ids',
        'country',
        'mail_body',
        'subject',
        'is_sent',
        'mail_sent_at'
    ];

    protected $casts = [
        'mail_sent_at' => 'datetime', 
    ];

}
