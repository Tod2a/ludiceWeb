<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * Get the categories associated with the game.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the mechanics associated with the game.
     */
    public function mechanics()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the publishers associated with the game.
     */
    public function publishers()
    {
        return $this->belongsToMany(Publisher::class);
    }

    /**
     * Get the creators associated with the game.
     */
    public function creators()
    {
        return $this->belongsToMany(Creator::class);
    }

    /**
     * Get the template sections for the game.
     */
    public function templatesections()
    {
        return $this->hasMany(TemplateSection::class);
    }

    public function library()
    {
        return $this->belongsToMany(User::class, 'library');
    }

    public function scoreSheets()
    {
        return $this->hasMany(ScoreSheet::class);
    }
}
