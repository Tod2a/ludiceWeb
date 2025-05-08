<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'score_sheet_id',
        'guest_id',
        'user_id',
        'score',
    ];

    /**
     * Boot method to validate the "either guest_id or user_id" rule.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($section) {
            if (!$section->guest_id && !$section->user_id) {
                throw new \Exception('A section must have either a guest_id or a user_id.');
            }

            if ($section->guest_id && $section->user_id) {
                throw new \Exception('A section cannot have both guest_id and user_id.');
            }
        });

        static::updating(function ($section) {
            if (!$section->guest_id && !$section->user_id) {
                throw new \Exception('A section must have either a guest_id or a user_id.');
            }

            if ($section->guest_id && $section->user_id) {
                throw new \Exception('A section cannot have both guest_id and user_id.');
            }
        });
    }

    public function scoreSheet()
    {
        return $this->belongsTo(ScoreSheet::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
