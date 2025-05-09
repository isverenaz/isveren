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

class HelloJobScrapingStrategy implements ScrapingStrategyInterface
{


    public function scrape($limit = 5, $postLimit = 5)
    {
        // Implement scraping logic for HelloJob website
        $site = 'https://www.hellojob.az/';
        $client = $this->initializeHttpClient();
        $response = $client->get($site);
        $htmlContent = $response->body();
        $crawler = new Crawler($htmlContent);
        $resoult = [];

        $classes = $crawler->filter('.col-md-8 .vacancies__item');

        $classes->each(function ($class) use (&$resoult, $client, $limit, $postLimit) {
            if (count($resoult) >= $limit) {
                return false; // Stop the loop if the limit is reached
            }
            $links = $class->filter('a');

            $links->each(function ($link) use (&$resoult, $client, $postLimit) {
                if (count($resoult) < $postLimit) {
                    $url = $link->attr('href');


                    $jobUrl = /*'https://www.hellojob.az' .*/ $url;
                    $jobUrl = $this->url($client, $jobUrl);
                    if ($jobUrl) {
                        $resoult[] = $jobUrl;
                    }
                }
            });
        });

        // Process the result as needed
        return $resoult;
    }

    // You can include the rest of the methods from HelloJobController@data here

    private function initializeHttpClient()
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        return Http::withHeaders(['User-Agent' => $userAgent]);
    }

    private function url($client, $jobUrl)
    {
//        $jobUrl = 'https://www.hellojob.az/vakansiya/surucu-16';
        $jobUrl = $client->get($jobUrl);
        try {
            if ($jobUrl->successful()) {
                $pageContent = $jobUrl->body();

                $data = [];
                $crawler = new Crawler($pageContent);

                $title = $crawler->filter('.vacancies__subTitle')->text();
                $company =  $crawler->filter('.vacancies__category.text-black')->text();
                $logo_url =  $crawler->filter('.vacancies__logo img')->attr('src');

                $logo = '';
                if (!empty($logo_url)) {
                    $imageData = @file_get_contents($logo_url);
                    if ($imageData === false) {
                        // Hata durumunda bildirim
                        Log::error("Logo URL'den veri alınamadı: $logo_url");
                    } else {
                        // Dosya uzantısını al
                        $extension = pathinfo($logo_url, PATHINFO_EXTENSION);
                        // Dosya adını tanımla
                        $fileName = 'public/uploads/companies/logo/' . preg_replace('/\s+/', '-', mb_strtolower($company, 'UTF-8')) . '.' . $extension;
                        Log::error("fileName: $fileName");
                        // Klasör yoksa oluştur
                        $directory = dirname($fileName);
                        if (!file_exists($directory)) {
                            if (!mkdir($directory, 0777, true)) {
                                // Hata durumunda bildirim
                                Log::error("Klasör oluşturulamadı: $directory");
                            }
                        }
                        // Dosyaya veriyi yaz
                        if (file_put_contents($fileName, $imageData) !== false) {
                            //
                            $logo = preg_replace('/\s+/', '-', mb_strtolower($company, 'UTF-8')) . '.' . $extension;
                            Log::error("Logo dosyaya kaydedilemedi: $logo");
                        } else {
                            // Hata durumunda bildirim
                            Log::error("Logo dosyaya kaydedilemedi: $fileName");
                        }
                    }

                }

                $city = $crawler->filter('.company__item__details li p')->text();
                $seniority = $crawler->filter('.company__item__details li')->eq(1)->filter('p')->text();
                $category = '';
                if ($crawler->filterXPath('//html/body/div[3]/section/div/div[1]/ul/li[3]')->count() > 0) {
                    $category = $crawler->filterXPath('//html/body/div[3]/section/div/div[1]/ul/li[3]')->text();
                }
                $sub_category = $crawler->filter('.company__item__details li')->eq(1)->filter('p')->text();
                $price = $crawler->filter('.company__item__details li')->eq(2)->filter('p')->text();
                $mode = $crawler->filter('.company__item__details li')->eq(3)->filter('p')->text();
                $education = $crawler->filter('.company__item__details li')->eq(4)->filter('p')->text();

                $start_day = $crawler->filter('.company__item__details li')->eq(5)->filter('p')->text();
//                dd();
                $end_day = $crawler->filter('.company__item__details li')->eq(6)->filter('p')->text();
                $scrape_id = $crawler->filter('.company__side-bar__title')->text();


                $email = '--';
//                /a[contains(@class, "show-email") and @data-copy
                /*if ($crawler->filterXPath('//html/body/div[3]/section/div/div[2]/div[2]/div/div[1]/ul/li[1]/a"]')->count() > 0) {
                    $email = $crawler->filterXPath('//html/body/div[3]/section/div/div[2]/div[2]/div/div[1]/ul/li[1]/a')->text();
                }*/

//                dd($email);
               /* if ($crawler->filter('ul[class="company__contacts"] li a')->text() == 'E-poçt göstər') {
                    $link = $crawler->filter('ul[class="company__contacts"] li a');
                    $email = $link->attr('href');
                }*/


                $phone = '--';
               /* if ($crawler->filterXPath('//html/body/div[3]/section/div/div[2]/div[2]/div/div[1]/ul/li[2]/a')->count() > 0) {
                    $phone = $crawler->filterXPath('//html/body/div[3]/section/div/div[2]/div[2]/div/div[1]/ul/li[2]/a')->text();
                }*/

                $desc = $crawler->filter('.company__text.section-spacing')->html();

                $removeSentence = '<p>Vakansiyalardan daha tez xəbərdar olmaq üçün <a href="https://t.me/hellojobaz" target="_blank">Telegram kanalımıza</a> abunə olun!</p>';

                if (strpos($desc, $removeSentence) !== false) {
                    $desc = str_replace($removeSentence, '', $desc);
                }
                $endText = $desc. '<p>Vakansiyalardan daha tez xəbərdar olmaq üçün <a href="https://t.me/isverenaz" target="_blank">Telegram kanalımıza</a> abunə olun!</p>';
                $datas = [
                    'scrape_id' => intval(preg_replace('/[^0-9]/', '', $scrape_id)),
                    'title' => $title,
                    'company' => $company,
                    'logo' => $logo,
                    'seniority' => $seniority,
                    'salary' => $price,
                    'city' => $city,
                    'mode' => $mode,
                    'category' => $category,
                    'sub_category' => $sub_category,
                    'education' => $education,
                    'email' => $email,
                    'phone' => $phone,
                    'start_day' => $start_day,
                    'end_day' => $end_day,
                    'desc' => $endText
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
            Log::info('Exception: ' . $e->getMessage());
        }
    }


    public static function job_data_save($datas)
    {
        // Log::info('job_data_save function completed with response: ' . json_encode($datas));


        $response = [];
        try {

            if (!empty($datas) && $datas != NULL) {
//                dd($datas);
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
                    $categories = Category::where('code', $categorycode)->first();

                    if (empty($categories)) {
                        //                        dd($categories);
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
                        //                        dd("ss");
                        $cat_id = $categories['id'];
                    }


                    $sub_category = (!empty($datas['sub_category']) ? $datas['sub_category'] : NULL);
                    $subcategorycode = (!empty($datas['sub_category']) ? mb_strtolower($datas['sub_category'], 'UTF-8') : NULL);


                    if (!empty($cat_id) && !empty($sub_category)) {
                        $parent_id = (empty($categories) ? $cat_id : $categories['id']);
                        $sub_categories = Category::where(['code' => $subcategorycode, 'parent_id' => $parent_id])->first();
                        if (empty($sub_categories)) {
                            $sub_category_name = [$lang => $datas['sub_category']];
                            Category::create([
                                'parent_id' => $cat_id,
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
                //end category

                // type city create
                $typecode = (!empty($datas['mode']) ? mb_strtolower($datas['mode'], 'UTF-8') : NULL);
                $types = JobType::where('code', $typecode)->first();
                if (
                    empty($types) && $typecode != NULL &&
                    ($typecode == 'part-time' || $typecode == 'full-time' || $typecode == 'freelance'
                        || $typecode == 'təcrübəçi' || $typecode == 'uzaqdan' || $typecode == 'tam-ştat')
                ) {
                    $type = $datas['mode'];
                    $type_name = [$lang => $type];

                    $typeData = new JobType();
                    $typeData->name = $type_name;
                    $typeData->code = $typecode;
                    $typeData->status = 1;
                    $typeData->save();
                    $type_id = DB::getPdo()->lastInsertId();
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
                    $companyDatas->logo = $datas['logo'];
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
                   $up= Company::where('code', $companycode)->update(['logo' => $datas['logo']]);
                    Log::info('$companycode '.$up);
                    $response = [
                        'success' => false,
                        'message' => 'Sirket bazada olduqu üçün qeyde alinmadi.',
                        'code' => 422
                    ];
                }


                //            return $response;
                // end company
                //start job
                $job_scrape_id = Job::where('scrape_id', $datas['scrape_id'])->first();

                $desc = [$lang => $datas['desc']];
                if (empty($job_scrape_id)) {
                    $title = [$lang => $datas['title']];
                    $seniority = [$lang => $datas['seniority']];
                    $creDayFormattedDate = $datas['start_day'];
                    $upFormattedDate = $datas['end_day'];

// Tarixi əl ilə düzgün formata çeviririk: "18 aprel 2025" -> "18 April 2025"
                    $monthMap = [
                        'yanvar' => 'January', 'fevral' => 'February', 'mart' => 'March', 'aprel' => 'April',
                        'may' => 'May', 'iyun' => 'June', 'iyul' => 'July', 'avqust' => 'August',
                        'sentyabr' => 'September', 'oktyabr' => 'October', 'noyabr' => 'November', 'dekabr' => 'December'
                    ];

                    if (!empty($datas['start_day'])) {
                        $creDayFormattedDate = str_ireplace(array_keys($monthMap), array_values($monthMap), strtolower($creDayFormattedDate));
                        $creDayFormattedDate = date('Y-m-d', strtotime($creDayFormattedDate));
                    } else {
                        $creDayFormattedDate = NULL;
                    }
                    if (!empty($datas['end_day'])) {
                        $upFormattedDate = str_ireplace(array_keys($monthMap), array_values($monthMap), strtolower($upFormattedDate));
                        $upFormattedDate = date('Y-m-d', strtotime($upFormattedDate));
                    } else {
                        $upFormattedDate = NULL;
                    }
//                    dd($upFormattedDate);
                    $job = new Job();
                    $job->scrape_id = $datas['scrape_id'];
                    $job->city_id = $city_id;//(empty($cities) ? $city_id : $cities['id']);
                    $job->job_type_id = $type_id;
                    $job->company_id = (empty($companies) ? $company_id : $companies['id']);
                    $job->title = $title;
                    $job->description = $desc;
                    $job->seniority = $seniority;
                    $job->price = $datas['salary'];
                    $job->email = $datas['email'] ?? NULL;
                    $job->phone = $datas['phone'] ?? NULL;
                    $job->logo = '0';
                    $job->status = 1;
                    $job->start_date = $creDayFormattedDate.' 00:00:00';
                    $job->end_date = $upFormattedDate.' 00:00:00';
                    $job->created_at = $creDayFormattedDate.' 00:00:00';
                    $job->updated_at = $upFormattedDate.' 00:00:00';

                    
                    $job->save();

//                    dd($job);
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
                    Job::where('scrape_id', $datas['scrape_id'])->update([
                        'email' => $datas['email'],
                        'phone' => $datas['phone'],
                        'status' => 1,
                        'description' => $desc,
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
                return [
                    'success' => false,
                    'message' => 'Məlumat boş olduqu üçün bazaya heçnə yazılmadı.',
                    'code' => 422
                ];
            }
        } catch (\Exception $e) {
            // Log the exception or handle it in some way
            Log::info('Exception: ' . $e->getMessage());
        }

        // Log::info('job_data_save function completed with response: ' . json_encode($response));
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
