<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyComplaint extends Model
{
    use HasFactory;
    protected $table = 'reply_complaint';
    
    protected $fillable = [
        'reply',
        'compt_id'
    ];
}
