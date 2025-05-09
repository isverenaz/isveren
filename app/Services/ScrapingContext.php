<?php

namespace App\Services;

use App\Contracts\ScrapingStrategyInterface;

class ScrapingContext
{
    private $strategy;

    public function setStrategy(ScrapingStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeScrape()
    {
        return $this->strategy->scrape();
    }
}
