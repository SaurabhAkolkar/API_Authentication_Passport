<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddComplaint extends Model
{
    use HasFactory;
    protected $table = 'add_complaint';

    protected $fillable = [
        'complaint'
    ];
}
