<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobType;
use App\Services\ScrapingContext;
use App\Scraping\Strategies\HelloJobScrapingStrategy;
use App\Scraping\Strategies\BossScrapingStrategy;
use Goutte\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PHPUnit\Util\Type;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ScrapingController extends Controller
{

    public function data($website)
    {
        // Create an instance of the context class
        $context = new ScrapingContext();

        // Determine the strategy based on the website parameter
        $strategy = $this->getScrapingStrategy($website);

        // Set the strategy
        $context->setStrategy($strategy);

        // Execute the scraping strategy
        $result = $context->executeScrape();

        // Handle the result as needed
        return response()->json($result);
    }

    private function getScrapingStrategy($website)
    {
        // Add more conditions for additional websites
        switch ($website) {
            case 'hellojob':
                return new HelloJobScrapingStrategy();
            case 'boss':
                return new BossScrapingStrategy();
            default:
                // Handle the case where no strategy is found
                throw new \InvalidArgumentException("No strategy found for website: $website");
        }
    }
}
