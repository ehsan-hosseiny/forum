<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    /**
     * @return Channel
     */
    public function channel(): Channel
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Answer
     */
    public function answer(): Answer
    {
        return $this->hasMany(Answer::class);
    }

}
