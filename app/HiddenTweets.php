<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiddenTweets extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tweet_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
