<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'slug',
        'message',
        'attachments_id',
        'category',
        'status'

    ];

    public function attachment() {
        return $this->belongsTo(Attachment::class, 'attachments_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}
