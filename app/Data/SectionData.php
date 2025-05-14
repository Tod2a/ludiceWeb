<?php

namespace App\Data;

class SectionData
{
    public array $scores;

    public function __construct(array $data)
    {
        $this->scores = array_map(fn($score) => new ScoreData($score), $data['scores']);
    }
}
