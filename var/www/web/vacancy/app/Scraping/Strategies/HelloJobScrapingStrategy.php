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

                    $jobUrl = 'https://www.hellojob.az' . $url;
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
                $title = $crawler->filter('.resume__header__name')->text();

                $company = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[1]/div[1]/div[2]/p/a')->count() > 0) {
                    $company = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[1]/div[1]/div[2]/p/a')->text();
                }


                $logo_url = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[1]/div/div[1]/img')->count() > 0) {
                    $logo_url = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[1]/div/div[1]/img')->attr('src');
                }
                Log::error("Logo URL: $logo_url");
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

                $city = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[3]/div/div[1]/div/div[2]/h4/a')->count() > 0) {
                    $city = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[3]/div/div[1]/div/div[2]/h4/a')->text();
                }

                $seniority = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[3]/div/div[2]/div/div[2]/h4')->count() > 0) {
                    $seniority = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[3]/div/div[2]/div/div[2]/h4')->text();
                }

                $mode = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[3]/div/div[4]/div/div[2]/h4/a')->count() > 0) {
                    $mode = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[3]/div/div[4]/div/div[2]/h4/a')->text();
                }

                $price = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[1]/div[2]/span')->count() > 0) {
                    // XPath ifadesi bulunduğunda değeri alabilirsiniz
                    $price = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[1]/div[2]/span')->text();
                }
                // bax
                $education = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[3]/div[2]')->count() > 0) {
                    $education = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[3]/div[2]')->text();
                }
                $relevant_person = '';
                if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[7]/div[2]')->count() > 0) {
                    $relevant_person = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[1]/ul/li[7]/div[2]')->text();
                }
                ///bax
                $sub_category = '';
                if ($crawler->filterXPath('//html/body/main/div[2]/div/ul/li[3]')->count() > 0) {
                    $sub_category = $crawler->filterXPath('//html/body/main/div[2]/div/ul/li[3]')->text();
                }

                $category = '';
                if ($crawler->filterXPath('//html/body/main/div[2]/div/ul/li[2]')->count() > 0) {
                    $category = $crawler->filterXPath('//html/body/main/div[2]/div/ul/li[2]')->text();
                }

                $desc = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[4]')->count() > 0) {
                    $text = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[4]')->html();
                    $removeSentence = '<p>Vakansiyalardan daha tez xəbərdar olmaq üçün <a href="https://bit.ly/hjtopbanner1" target="_blank">Telegram kanalımıza</a> abunə olun!</p>';

                    if (($startPos = strpos($text, $removeSentence)) !== false) {
                        $text = substr_replace($text, '', $startPos, strlen($removeSentence));
                    }

                    $endRemoveSentence = '<p>Daha çox <a href="https://bit.ly/isbulink" target="_blank">Sürücü vakansiyaları</a> isbu.az-da - Axtardığın işbu!</p>';
                    if (($startPos = strpos($text, $endRemoveSentence)) !== false) {
                        $text = substr_replace($text, '', $startPos, strlen($endRemoveSentence));
                    }
                    $desc = $text;
//
                    //                    $removeSentence = '<hr><p>Vakansiyalardan daha tez xəbərdar olmaq üçün <a href="https://bit.ly/hjtopbanner1" target="_blank">Telegram kanalımıza</a> abunə olun!</p>';
                    //                    $removeSentencedesc = str_replace($removeSentence, '', $text);
                    //                    $endRemoveSentence = '<p>Daha çox <a href="https://bit.ly/isbulink" target="_blank">SPA və gözəllik vakansiyaları</a> isbu.az-da - Axtardığın işbu!</p>';
                    //                    $desc = str_replace($endRemoveSentence, '', $removeSentencedesc);
                }

                $scrape_id = 0;
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[2]/div/div/div/div[1]/h4')->count() > 0) {
                    $scrape_id = $crawler->filterXPath('//html/body/main/section/div/div/div[2]/div/div/div/div[1]/h4')->text();
                }

                $email = '';

                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[5]/div/div/div[1]/a')->count() > 0) {
                    $email = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[5]/div/div/div[1]/a')->text();
                }
                if ($crawler->filter('div[class="resume__item__text"] h4 a')->text() == 'Müraciət linki') {
                    $link = $crawler->filter('div[class="resume__item__text"] h4 a');

                    $email = $link->attr('href');
                }




                $phone = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[5]/div/div/div[1]/a[3]')->count() > 0) {
                    $phone = $crawler->filterXPath('//html/body/main/section/div/div/div[1]/div[5]/div/div/div[1]/a[3]')->text();
                }

                $start_day = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[2]/div/div/div/div[2]/div/div[1]/div/div[2]/h4')->count() > 0) {
                    $start_day = $crawler->filterXPath('//html/body/main/section/div/div/div[2]/div/div/div/div[2]/div/div[1]/div/div[2]/h4')->text();
                }

                $end_day = '';
                if ($crawler->filterXPath('//html/body/main/section/div/div/div[2]/div/div/div/div[2]/div/div[2]/div/div/h4')->count() > 0) {
                    $end_day = $crawler->filterXPath('//html/body/main/section/div/div/div[2]/div/div/div/div[2]/div/div[2]/div/div/h4')->text();
                }

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
                    'relevant_person' => $relevant_person,
                    'email' => $email,
                    'phone' => $phone,
                    'start_day' => $start_day,
                    'end_day' => $end_day,
                    'desc' => $desc
                ];
                //            return $datas;
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
                if (empty($cities) && $citycode != NULL) {
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
                }
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
                Log::info( 'emil');

                // Check if companycode is not null or empty
                if (empty($companycode)) {
                    throw new \Exception('Company code is undefined or empty');
                }                   $companies = Company::where('code', $companycode)->first();
                if (empty($companies) && $companycode != NULL) {
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
                    Log::info( 'fuad');

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
                if (empty($job_scrape_id)) {
                    $title = [$lang => $datas['title']];
                    $desc = [$lang => $datas['desc']];
                    $seniority = [$lang => $datas['seniority']];

                    $start_day = $datas['start_day'] . " 2024";
                    $end_day = $datas['end_day'] . " 2024";
                    $monthTranslations = [
                        'Yanvar' => 'January',
                        'Fevral' => 'February',
                        'Mart' => 'March',
                        'Aprel' => 'April',
                        'May' => 'May',
                        'İyun' => 'İyun',
                        'Iyul' => 'July',
                        'Avqust' => 'August',
                        'Sentyabr' => 'September',
                        'Oktyabr' => 'October',
                        'Noyabr' => 'November',
                        'Dekabr' => 'December',
                    ];
                    if (!empty($datas['start_day'])) {
                        list($startDay, $startMonth, $startYear) = explode(' ', $start_day);
//                        $startCarbonDate = Carbon::createFromFormat('d F Y', $startDay . ' ' . $monthTranslations[$startMonth] . ' ' . $startYear, 'Asia/Baku');
                        $startCarbonDate = Carbon::createFromFormat('d F Y', $startDay . ' ' . 'June' . ' ' . $startYear, 'Asia/Baku');

                        $creDayFormattedDate = $startCarbonDate->format('d.m.Y');
                    } else {
                        $creDayFormattedDate = NULL;
                    }
                    if (!empty($datas['end_day'])) {
                        list($endDay, $endMonth, $endYear) = explode(' ', $end_day);
//                        $endCarbonDate = Carbon::createFromFormat('d F Y', $endDay . ' ' . $monthTranslations[$endMonth] . ' ' . $endYear, 'Asia/Baku');

                        $endCarbonDate = Carbon::createFromFormat('d F Y', $endDay . ' ' . 'June' . ' ' . $endYear, 'Asia/Baku');

                        $upFormattedDate = $endCarbonDate->format('d.m.Y');
                    } else {
                        $upFormattedDate = NULL;
                    }

                    $job = new Job();
                    $job->scrape_id = $datas['scrape_id'];
                    $job->city_id = (empty($cities) ? $city_id : $cities['id']);
                    $job->job_type_id = $type_id;
                    $job->company_id = (empty($companies) ? $company_id : $companies['id']);
                    $job->title = $title;
                    $job->description = $desc;
                    $job->seniority = $seniority;
                    $job->price = $datas['salary'];
                    $job->email = $datas['email'];
                    $job->logo = '0';
                    $job->status = 1;
                    $job->created_at = $creDayFormattedDate;
                    $job->updated_at = $upFormattedDate;
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
}
