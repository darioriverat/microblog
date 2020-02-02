<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'friendly_url',
        'friendly_url_hash',
        'created_by',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
