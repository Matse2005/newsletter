<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Newsletter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'date',
        'email',
        'group_id',
        'language_id',
        'send_at',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'group',
        'language'
    ];

    /**
     * Get the group that the newsletter will be send to.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * Get the language that the newsletter will be send in.
     * If the associated language cannot be found, return the language with key 'default'.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id')->withDefault(function () {
            return Language::where('key', 'default')->first();
        });
    }
}
