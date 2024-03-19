<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * 
     */
    protected $fillable = [
        'starts_at',
        'ends_at',
        'subject',
        'date', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * 
     */
    protected $hidden = [
        'user_id'
    ];

}
