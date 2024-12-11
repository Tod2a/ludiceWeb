<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSection extends Model
{
    use HasFactory;

    /**
     * Get the game associated with the template section.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
