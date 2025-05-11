<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    use HasFactory;

    /**
     * Get the games associated with the creator.
     */
    public function games()
    {
        return $this->belongsToMany(Game::class);
    }
}
