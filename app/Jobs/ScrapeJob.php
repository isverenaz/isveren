<?php

namespace App\Jobs;

use App\Scraping\Strategies\BossScrapingStrategy;
use App\Scraping\Strategies\HelloJobScrapingStrategy;
use App\Services\ScrapingContext;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScrapeJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $website;

    public function __construct($website)
    {
        $this->website = $website;
    }

    public function handle()
    {
        // Create an instance of the context class
        $context = new ScrapingContext();

        // Determine the strategy based on the website parameter
        $strategy = $this->getScrapingStrategy($this->website);

        // Set the strategy
        $context->setStrategy($strategy);

        // Execute the scraping strategy
        $result = $context->executeScrape();

        // Handle the result as needed
        // ...

        // For demonstration purposes, you can log the result
        Log::info('Scraping result:', ['result' => $result]);
    }

    private function getScrapingStrategy($website)
    {
        switch ($website) {
            case 'hellojob':
                return new HelloJobScrapingStrategy();
            case 'boss':
                return new BossScrapingStrategy();
            default:
                throw new \InvalidArgumentException("No strategy found for website: $website");
        }
    }
}
