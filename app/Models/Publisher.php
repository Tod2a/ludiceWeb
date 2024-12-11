<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    /**
     * Get the games associated with the publisher.
     */
    public function games()
    {
        return $this->belongsToMany(Game::class);
    }
}
