<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group',
        'description',
        'emails',
        'editable'
    ];

    protected $casts = [
        'emails' => 'array',  // Automatically casts the 'emails' field to an array
    ];
}
