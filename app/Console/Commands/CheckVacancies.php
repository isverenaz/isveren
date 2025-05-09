<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CheckVacancies extends Command
{
    protected $signature = 'scrape:test';
    protected $description = 'Check new job vacancies and send them to Telegram';

    private $vacancyUrl = 'https://isveren.az';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $this->info('Checking for new vacancies...');
        $client = new Client();
        $crawler = $client->request('GET', $this->vacancyUrl);

        $jobs = $crawler->filter('.job-item');
        $this->info("Number of job cards found: " . $jobs->count());

        if ($jobs->count() === 0) {
            $this->info('No vacancies found.');
            return;
        }

        $newJobs = [];
        $jobs->each(function ($job) use (&$newJobs) {
            $jobTitle = $job->filter('.job-title')->text('No Title Found');
            $companyName = $job->filter('.job-company')->text('No Company Found');

//            $salary = $job->filter('.job-rate p')->text('No Salary Info Found');
//            $jobLink = $job->filter('a')->link()->getUri();
            $linkNode = $job->filter('.job-title a');
            $jobLink = $linkNode->count() > 0 ? $linkNode->link()->getUri() : null;

            if (empty($jobTitle) || empty($companyName) || /*empty($salary) ||*/ empty($jobLink)) {
                $this->info("Skipping job due to missing information.");
                return;
            }
//            dd(!Cache::has('job_' . md5($jobLink)));
            // Check if the jobLink is already in the cache
            if (!Cache::has('job_' . md5($jobLink))) {

                // Store the job link in cache for a day (or set a suitable expiration)
                Cache::forever('job_' . md5($jobLink), true);
//                \n💵 {$salary}
                $newJobs[] = "💼 {$jobTitle}\n🏢 {$companyName}\n🔗 {$jobLink}";
            }

        });
//        dd($newJobs);
        if (!empty($newJobs)) {
            $message = "🔔 " . count($newJobs) . " yeni vakansiya:\n\n" . implode("\n\n", $newJobs);
//            dd($message);
            $this->sendToTelegram($message);
//            $this->sendToLinkedin($message);
        } else {
            $this->info('No new vacancies.');
        }
    }

    private function sendToTelegram($message)
    {
        $botToken = '7075788652:AAEMOn_liKR3BoWQyrXJbicHm0StJaB4a2E';
        $channelUsername = '@isverenaz';
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
//        dd($url);
        $response = Http::post($url, [
            'chat_id' => $channelUsername,
            'text' => $message,
        ]);

        if ($response->successful()) {
            $this->info('Message sent to Telegram.');
        } else {
            $this->error('Failed to send message to Telegram.');
            dd($response);  // Yanıtı görme
        }
    }
    private function sendToLinkedin($message)
    {
        // Cache-dən access token-i oxuyuruq
        $accessToken = Cache::get('linkedin_access_token');

        // Əgər token tapılmırsa, istifadəçiyə yenidən avtorizasiya olmaq lazım olduğunu bildiririk
        if (!$accessToken) {
            $this->error('❌ LinkedIn access token tapılmadı. Əvvəlcə avtorizasiya olun:');
            $this->info('➡️ Açın: ' . route('linkedin.authorize')); // Bu URL istifadəçiyə göstərilir
            return;
        }
//        dd($accessToken);

        // Organization ID-ni bura daxil et (əgər sabitdirsə)
        $organizationId = '100632394';  // Tapdığınız organizationId
        // LinkedIn API-yə post göndəririk
        $response = Http::withToken($accessToken)
            ->post('https://api.linkedin.com/v2/ugcPosts', [
                'author' => 'urn:li:organization:100632394',
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => 'test'
                        ],
                        'shareMediaCategory' => 'NONE' // Heç bir media olmadan
                    ]
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
                ]
            ]);

//        dd($message);
        // LinkedIn API cavabını yoxlayırıq
        if ($response->successful()) {
            $this->info('✅ Mesaj LinkedIn-ə göndərildi.');
        } else {
            $this->error('❌ Mesaj LinkedIn-ə göndərilə bilmədi.');
            dd($response->json());
        }
    }
}
