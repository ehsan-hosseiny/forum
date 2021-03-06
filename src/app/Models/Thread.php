<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return Channel
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
