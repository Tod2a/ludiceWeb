<?php

namespace App\Data;

class ScoreSheetData
{
    public int $game_id;
    public array $sections;

    public function __construct(array $data)
    {
        $this->game_id = $data['game_id'];
        $this->sections = array_map(fn($section) => new SectionData($section), $data['sections']);
    }
}
