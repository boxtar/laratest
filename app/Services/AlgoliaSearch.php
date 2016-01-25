<?php

namespace App\Services;

use App\Contracts\Search;

class AlgoliaSearch implements Search{

    protected $table;

    public function in($table)
    {
        $this->table = $table;
        return $this;
    }

    public function find($query)
    {
        return 'finding '.$query.' in table '.$this->table;
    }
}