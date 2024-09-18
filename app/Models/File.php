<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'file_path',
        'file_url'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            // Ensure that file_path is not empty
            if ($model->file_path) {
                // Delete the file from the storage disk
                Storage::disk('public')->delete($model->file_path);
            }
        });
    }
}
