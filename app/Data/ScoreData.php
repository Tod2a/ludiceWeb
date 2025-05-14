<?php

namespace App\Data;

class ScoreData
{
    public ?int $user_id;
    public ?int $guest_id;
    public ?float $score;

    public function __construct(array $data)
    {
        $this->user_id = $data['user_id'] ?? null;
        $this->guest_id = $data['guest_id'] ?? null;
        $this->score = $data['score'] ?? null;
    }
}
