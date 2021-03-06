<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * @return Thread
     */
    public function threads():Thread
    {
        return $this->hasMany(Thread::class);

    }
}
