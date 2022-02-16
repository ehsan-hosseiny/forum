<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return User
     */
    public function user(): User
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Thread
     */
    public function thread(): Thread
    {
        return $this->belongsTo(Thread::class);
    }
}
