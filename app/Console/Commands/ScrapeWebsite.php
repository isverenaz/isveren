<?php

namespace App\Console\Commands;

use App\Http\Controllers\Web\ScrapingController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;


class ScrapeWebsite extends Command
{

    protected $commands = [
        \App\Console\Commands\ScrapeWebsite::class,
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape website data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $helloJobController = new ScrapingController();
        $helloJobController->data('hellojob');

        $bossController = new ScrapingController();
        $bossController->data('boss');

        // Artisan::call('scrape:test');

        //olmasa bunu elave etmek
        // if (!Cache::has('scrape_test_last_run')) {
        //     Artisan::call('scrape:test');
        //     Cache::put('scrape_test_last_run', true, now()->addHours(4));
        // }


        $this->info('Scraping completed successfully.');
    }
}
