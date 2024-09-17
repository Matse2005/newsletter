<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'title',
        'local',
        'translations'
    ];

    // protected $casts = [
    //     'translations' => 'array',  // Automatically casts the 'emails' field to an array
    // ];
}
