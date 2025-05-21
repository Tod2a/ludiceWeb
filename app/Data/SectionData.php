<?php

namespace App\Data;

class SectionData
{
    public string $name;
    public array $scores;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->scores = array_map(fn($score) => new ScoreData($score), $data['scores']);
    }
}
