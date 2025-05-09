<?php

namespace App\Scraping\Strategies;

use App\Models\City;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\Seo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use App\Contracts\ScrapingStrategyInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;

class BossScrapingStrategy implements ScrapingStrategyInterface
{

    public function scrape($limit = 5, $postLimit = 5)
    {
        // Implement scraping logic for HelloJob website
        $site = 'https://boss.az/vacancies';

        $client = $this->initializeHttpClient();
        $response = $client->get($site);
        $htmlContent = $response->body();
        $crawler = new Crawler($htmlContent);
        $classes = $crawler->filter('.results .results-i');
        $result = [];

        $classes->each(function ($class) use (&$result, $client, $limit, $postLimit) {
            if (count($result) >= $limit) {
                return false; // Stop the loop if the limit is reached
            }
            $links = $class->filter('.results-i-salary-and-link .results-i-link');
            $links->each(function ($link) use (&$result, $client, $postLimit) {
                if (count($result) < $postLimit) {
                    $url = $link->attr('href');
                    $jobUrl = 'https://www.boss.az' . $url;
                    $jobUrl = $this->url($client, $jobUrl);
                    if ($jobUrl) {
                        $result[] = $jobUrl;
                    }
                }
            });
        });
        return $result;
    }

    // You can include the rest of the methods from HelloJobController@data here

    private function initializeHttpClient()
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        return Http::withHeaders(['User-Agent' => $userAgent]);
    }

    private function url($client, $jobUrl)
    {
        $jobUrl = $client->get($jobUrl);
        try {
            if ($jobUrl->successful()) {
                $pageContent = $jobUrl->body();

                $crawler = new Crawler($pageContent);
                $scrape_id = '';
                if ($crawler->filterXPath('//html/body/div[3]/div[1]/div[2]/div[2]')->count() > 0) {
                    $scrape_id = $crawler->filterXPath('//html/body/div[3]/div[1]/div[2]/div[2]')->text();
                }
                $title = $crawler->filter('.post-title')->text();
                $company = $crawler->filter('.post-company')->text();
                $price = '';
                if ($crawler->filterXPath('//html/body/div[3]/div[1]/div[2]/div[1]/span')->count() > 0) {
                    $price = $crawler->filterXPath('//html/body/div[3]/div[1]/div[2]/div[1]/span')->text();
                }

                //bax
                $mode = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[3]/div/div[4]/div/div[2]/h4/a')->count() > 0) {
                    $mode = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[3]/div/div[4]/div/div[2]/h4/a')->text();
                }

                $category = '';
                if ($crawler->filterXPath('//html/body/div[3]/div[1]/div[1]/a[1]')->count() > 0) {
                    $category = $crawler->filterXPath('//html/body/div[3]/div[1]/div[1]/a[1]')->text();
                }
                $sub_category = '';
                if ($crawler->filterXPath('//html/body/div[3]/div[1]/div[1]/a[2]')->count() > 0) {
                    $sub_category = $crawler->filterXPath('//html/body/div[3]/div[1]/div[1]/a[2]')->text();
                }

                //                dd($sub_category);

                //bax

                $city = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[1]/div[2]')->count() > 0) {
                    $city = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[1]/div[2]')->text();
                }

                $age = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[2]/div[2]')->count() > 0) {
                    $age = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[2]/div[2]')->text();
                }


                $education = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[3]/div[2]')->count() > 0) {
                    $education = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[3]/div[2]')->text();
                }


                $seniority = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[4]/div[2]')->count() > 0) {
                    $seniority = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[4]/div[2]')->text();
                }

                $start_date = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[5]/div[2]')->count() > 0) {
                    $start_date = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[5]/div[2]')->text();
                }

                $end_date = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[6]/div[2]')->count() > 0) {
                    $end_date = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[6]/div[2]')->text();
                }

                $relevant_person = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[7]/div[2]')->count() > 0) {
                    $relevant_person = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[7]/div[2]')->text();
                }

                $email = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[2]/ul/li[2]/div[2]/a/span')->count() > 0) {
                    $encoded = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[2]/ul/li[2]/div[2]/a/span')->attr('data-cfemail');
                    $email = $this->cfDecodeEmail($encoded);
                }

                $phone = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[2]/ul/li[1]/div[2]/a[@class="phone"]')->count() > 0) {
                    $phone = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[2]/ul/li[1]/div[2]/a[@class="phone"]')->html();
                }

                $desc = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[6]')->count() > 0) {
                    $desc = $crawler->filterXPath('//html/body/div[3]/div/div[6]')->html();
                }
                $string = $scrape_id;

                // Use preg_match to extract the numeric value
                if (preg_match('/#(\d+)/', $string, $matches)) {
                    $numericValue = $matches[1];
                } else {
                    $numericValue = '';
                }

                $datas = [
                    'scrape_id' => $numericValue, //intval(preg_replace('/[^0-9]/', '', $numericValue)),
                    'title' => $title,
                    'company' => $company,
                    'seniority' => $seniority,
                    'salary' => $price,
                    'city' => $city,
                    'age' => $age,
                    'mode' => $mode,
                    'category' => $category,
                    'sub_category' => $sub_category,
                    'education' => $education,
                    'relevant_person' => $relevant_person,
                    'email' => $email,
                    'phone' => $phone,
                    'start_day' => $start_date,
                    'end_day' => $end_date,
                    'desc' => $desc. '<p>Vakansiyalardan daha tez xəbərdar olmaq üçün <a href="https://t.me/isverenaz" target="_blank">Telegram kanalımıza</a> abunə olun!</p>'
                ];

                if (!empty($datas)) {
                    $job_data_save = self::job_data_save($datas);
                    return $job_data_save;
                } else {
                    return $datas;
                }
            }
        } catch (\Exception $e) {
            // Log the exception or handle it in some way
            Log::error('Exception: ' . $e->getMessage());
        }
    }

    public static function job_data_save($datas)
    {
/*        Log::info('job_data_save function completed with response: ' . json_encode($datas));
        Log::info('ssssss');*/
        try {
            $response = [];
            if (!empty($datas) && $datas != NULL) {

                $lang = app()->getLocale();

                // start city create
                $citycode = (!empty($datas['city']) ? mb_strtolower($datas['city'], 'UTF-8') : NULL);
                $cities = City::where('code', $citycode)->first();
                $city_id = !empty($cities->id)? $cities->id : 1;
                /*if (empty($cities) && $citycode != NULL) {
                    $city = $datas['city'];
                    $city_name = [$lang => $city];

                    $cityData = new City();
                    $cityData->name = $city_name;
                    $cityData->code = $citycode;
                    $cityData->status = 1;
                    $cityData->save();
                    $city_id = DB::getPdo()->lastInsertId();
                    $response = [
                        'success' => true,
                        'message' => 'Şəhər bazaya yazıldı.',
                        'code' => 200
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Şəhər bazada olduqu üçün qeyde alinmadi.',
                        'code' => 422
                    ];
                }*/
                // end city create
                // start category and sub category create
                $category = (!empty($datas['category']) ? $datas['category'] : NULL);
                $categorycode = (!empty($datas['category']) ? mb_strtolower($datas['category'], 'UTF-8') : NULL);


                if (!empty($category)) {
                    if (empty($categories)) {
                        $categories = Category::where('code', $categorycode)->first();
                        if (empty($categories)) {
                            $category_name = [$lang => $datas['category']];
                            $cat = new Category();
                            $cat->name =  $category_name;
                            $cat->code = $categorycode;
                            $cat->status = 1;
                            $cat->save();
                            $cat_id = DB::getPdo()->lastInsertId();
                            $response = [
                                'success' => true,
                                'message' => 'Cat bazaya yazıldı.',
                                'code' => 200
                            ];
                        } else {
                            $cat_id = $categories['id'];
                        }
                    }

                    //                    dd($cat_id);
                    $sub_category = (!empty($datas['sub_category']) ? $datas['sub_category'] : NULL);
                    $subcategorycode = (!empty($datas['sub_category']) ? mb_strtolower($datas['sub_category'], 'UTF-8') : NULL);


                    if (!empty($cat_id) && !empty($sub_category)) {
//                        dd($subcategorycode);
                        $parent_id = (empty($categories) ? $cat_id : $categories['id']);
                        $sub_categories = Category::where(['code' => $subcategorycode, 'parent_id' => $parent_id])->first();
//                        dd($sub_categories);
                        if (empty($sub_categories)) {
                            $sub_category_name = [$lang => $datas['sub_category']];
                            Category::create([
                                'parent_id' => (empty($categories) ? $cat_id : $categories['id']),
                                'name' => $sub_category_name,
                                'code' => $subcategorycode,
                                'status' => 1
                            ]);

                            $sub_cat_id = DB::getPdo()->lastInsertId();
                            $response = [
                                'success' => true,
                                'message' => 'Sub Cat bazaya yazıldı.',
                                'code' => 200
                            ];
                        } else {
                            $sub_cat_id = $sub_categories['id'];
                        }
                    }
                }
//                dd($sub_cat_id);
                //end category

                // type city create
                $typecode = (!empty($datas['mode']) ? mb_strtolower($datas['mode'], 'UTF-8') : NULL);
                $types = JobType::where('code', $typecode)->first();
                if (empty($types) && $typecode != NULL) {
                    $type = $datas['mode'];
                    $type_name = [$lang => $type];

                    $typeData = new JobType();
                    $typeData->name = $type_name;
                    $typeData->code = $typecode;
                    $typeData->status = 1;
                    $typeData->save();
                    $type_id = $typeData->id;
                    $response = [
                        'success' => true,
                        'message' => 'Type bazaya yazıldı.',
                        'code' => 200
                    ];
                } else {
                    $type_id = isset($types['id']) ? $types['id'] : 1;
                    $response = [
                        'success' => false,
                        'message' => 'Type bazada olduqu üçün qeyde alinmadi.',
                        'code' => 422
                    ];
                }
                // end type

                //start company
                $companycode = (!empty($datas['company']) ? mb_strtolower($datas['company'], 'UTF-8') : NULL);
                $companies = Company::where('code', $companycode)->where('code', '!=','cermington llc')->first();
                if (empty($companies) && $companycode != NULL && $companycode != 'cermington llc') {
                    $company = $datas['company'];
                    $company_name = [$lang => $company];

                    $companyDatas = new Company();
                    $companyDatas->name = $company_name;
                    $companyDatas->address = $company_name;
                    $companyDatas->description = $company_name;
//                    $companyDatas->logo = '0';
                    $companyDatas->contract = '0';
                    $companyDatas->code = $companycode;
                    $companyDatas->status = 1;
                    $companyDatas->save();
                    $company_id = DB::getPdo()->lastInsertId();
                    $response = [
                        'success' => true,
                        'message' => 'Type bazaya yazıldı.',
                        'code' => 200
                    ];
                } else {
//                    $up= Company::where('code', $companycode)->update(['logo' => $companies['logo']]);
//                    Log::info('test '.$up);
                    $response = [
                        'success' => false,
                        'message' => 'Type bazada olduqu üçün qeyde alinmadi.',
                        'code' => 422
                    ];
                }

                $job_scrape_id = Job::where('scrape_id', $datas['scrape_id'])->first();
                $jobCode = (!empty($datas['title']) ? Str::slug($datas['title']) : NULL);
                $jobCode = [$lang => $jobCode];
                if (empty($job_scrape_id)) {
                    $title = [$lang => $datas['title']];
                    $desc = [$lang => $datas['desc']];
                    $seniority = [$lang => $datas['seniority']];

                    $start_day = $datas['start_day'];
                    $monthTranslations = [
                        'Yanvar' => 'January',
                        'Fevral' => 'February',
                        'Mart' => 'March',
                        'Aprel' => 'April',
                        'May' => 'May',
                        'İyun' => 'June',
                        'İyul' => 'July',
                        'Avqust' => 'August',
                        'Sentyabr' => 'September',
                        'Oktyabr' => 'October',
                        'Noyabr' => 'November',
                        'Dekabr' => 'December',
                    ];

                    list($startMonth, $startDay, $startYear) = explode(' ', $start_day);
                    $startDay = rtrim($startDay, ',');

                    if (array_key_exists($startMonth, $monthTranslations)) {
                        // Create a Carbon date object
                        $startCarbonDate = Carbon::createFromFormat('F d Y', $monthTranslations[$startMonth] . ' ' . $startDay . ' ' . $startYear, 'Asia/Baku');
                        // Format the date in the desired format
                        $creDayFormattedDate = $startCarbonDate->format('Y-m-d H:i:s');
                    }


                    $end_day = $datas['end_day'];
                    $endmonthTranslations = [
                        'Yanvar' => 'January',
                        'Fevral' => 'February',
                        'Mart' => 'March',
                        'Aprel' => 'April',
                        'May' => 'May',
                        'İyun' => 'June',
                        'İyul' => 'July',
                        'Avqust' => 'August',
                        'Sentyabr' => 'September',
                        'Oktyabr' => 'October',
                        'Noyabr' => 'November',
                        'Dekabr' => 'December',
                    ];
                    list($endMonth, $endDay, $endYear) = explode(' ', $end_day);
                    $endDay = rtrim($endDay, ',');

                    if (array_key_exists($endMonth, $endmonthTranslations)) {
                        // Create a Carbon date object
                        $endCarbonDate = Carbon::createFromFormat('F d Y', $endmonthTranslations[$endMonth] . ' ' . $endDay . ' ' . $endYear, 'Asia/Baku');
                        // Format the date in the desired format
                        $upFormattedDate = $endCarbonDate->format('Y-m-d H:i:s');
                    }

                    //                    dd($cat_id);
                    $job = new Job();
                    $job->scrape_id = $datas['scrape_id'];
                    $job->city_id = $city_id;//(empty($cities) ? $city_id : $cities['id']);
                    $job->job_type_id = NULL;
                    $job->company_id = (empty($companies) ? $company_id : $companies['id']);
                    $job->title = $title;
                    $job->code = $jobCode;
                    $job->description = $desc;
                    $job->seniority = $seniority;
                    $job->price = $datas['salary'];
                    $job->email = $datas['email'];
                    $job->phone = $datas['phone'];
                    $job->logo = 'null.png';
                    $job->status = 1;
                    $job->start_date = (!empty($creDayFormattedDate) ? $creDayFormattedDate : NULL);
                    $job->end_date = (!empty($upFormattedDate) ? $upFormattedDate : NULL);
                    $job->created_at = (!empty($creDayFormattedDate) ? $creDayFormattedDate : NULL);
                    $job->updated_at = (!empty($upFormattedDate) ? $upFormattedDate : NULL);
                    $job->save();

                    $jobCategory = new JobCategory();
                    $jobCategory->job_id = $job->id;
                    $jobCategory->category_id = $cat_id;
                    $jobCategory->sub_category_id = $sub_cat_id;
                    $jobCategory->save();

                    $meta_title = [$lang => Str::slug(trim($datas['title']))];
                    $meta_desc = [$lang => Str::slug(trim($datas['desc']))];
                    $meta_keyword = [$lang => Str::slug(trim('isveren.az'))];

                    $seo = new Seo();
                    $seo->sub_id = $job->id;
                    $seo->sub_table = 'jobs';
                    $seo->meta_title = $meta_title;
                    $seo->meta_description = $meta_desc;
                    $seo->meta_keyword = $meta_keyword;
                    $seo->save();

                    $response = [
                        'success' => true,
                        'message' => 'Məlumat bazaya yazıldı.',
                        'code' => 200
                    ];
                } else {
//                    dd($jobCode);
                    Job::where('scrape_id', $datas['scrape_id'])->update([
                    'email' => $datas['email'],
                     'phone' => $datas['phone'],
                     'status' => 1,
                     'code' => $jobCode,
                     'start_date' => (!empty($creDayFormattedDate) ? $creDayFormattedDate : NULL),
                     'end_date' => (!empty($upFormattedDate) ? $upFormattedDate : NULL)
                    ]);
                    $response = [
                        'success' => false,
                        'message' => 'Vakansiya bazada olduqu üçün qeyde alinmadi',
                        'code' => 422
                    ];
                }

                return $response;
            } else {
                Log::info('job_data_save function completed with response: ' . json_encode($response));
                Log::info('ssssss');
                return [
                    'success' => false,
                    'message' => 'Məlumat boş olduqu üçün bazaya heçnə yazılmadı.',
                    'code' => 422
                ];
            }

        } catch (\Exception $e) {
            // Log the exception or handle it in some way
            Log::error('Exception: ' . $e->getMessage());
        }
    }

    public function cfDecodeEmail(?string $encoded)
    {
        $k = hexdec(substr($encoded, 0, 2));
        $email = '';
        for ($i = 2; $i < strlen($encoded); $i += 2) {
            $charCode = hexdec(substr($encoded, $i, 2)) ^ $k;
            $email .= chr($charCode);
        }
        return $email;
    }
}
