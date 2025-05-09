<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class BossController extends Controller
{
    private function initializeHttpClient()
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        //Bu, sorğunun veb serverə brauzer kimi görünməsinə səbəb olur.
        return Http::withHeaders(['User-Agent' => $userAgent]);
    }

    public function data()
    {

        $site = 'https://boss.az/vacancies';

        $client = $this->initializeHttpClient();
        $response = $client->get($site);
        $htmlContent = $response->body();
        $crawler = new Crawler($htmlContent);
        $classes = $crawler->filter('.results .results-i');

        $classes->each(function ($class) use (&$resoult, $client) {
            $links = $class->filter('.results-i-salary-and-link .results-i-link');
            $links->each(function ($link) use (&$resoult, $client) {
                $url = $link->attr('href');
                $jobUrl = 'https://www.boss.az' . $url;
                $jobUrl = $this->url($client, $jobUrl);
                if ($jobUrl) {
                    $resoult[] = $jobUrl;
                }
            });
        });
        echo "<pre>";
        print_r($resoult);
        die();
    }

    private function url($client, $jobUrl)
    {
        $jobUrl = $client->get($jobUrl);
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

            $phone = '';
            if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[2]/ul/li[1]/div[2]')->count() > 0) {
                $phone = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[2]/ul/li[1]/div[2]')->text();
            }

            $email = '';
            if ($crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[2]/ul/li[2]/div[2]/a')->count() > 0) {
                $email = $crawler->filterXPath('//html/body/div[3]/div/div[5]/div/div[2]/ul/li[2]/div[2]/a')->text();
            }

            $desc = '';
            if ($crawler->filterXPath('//html/body/div[3]/div/div[6]')->count() > 0) {
                $text = $crawler->filterXPath('//html/body/div[3]/div/div[6]')->html();
//                $text = 'Senser lingerie qadın iç geyim mağazasına XANIM satış təmsilçisi tələb olunur. AR əmək məcəlləsi üzrə rəsmi sənədləşmə Mağaza məhsullarının satışını həyata keçirmək. Mağaza qaydalarına əməl etmək. İşinə məsuliyyətli yanaşmaq; Öz üzərində işləmək və daim inkişafa açıq olmaq 10:00-21:00-Növbəli Həftədə 1 gün istirahət Əmək haqqı: 400-800 AZN( + satışın %-i + bonus) NAMİZƏDƏ TƏLƏBLƏR Ali və ya orta təhsil mütləqdir; Peşəkar səviyyədə Azərbaycan dili biliyi; Rus dili arzuolunandır; Ünsiyyətcil olmaq və kollektivlə birgə işləməyi bacarmaq. Yaş: 18-35(xanım) Ünvan:Hüseyn Cavid.81(Elmlər) Əcəmi m\s.Hüseynbala Əliyev 3 Genclik:Atatürk pr. 31 Özünüz haqqında məlumatları CV formasında "Satış təmsilçisi" başlığı ilə "senserlingerie@mail.ru" ünvanına göndərə bilərsiniz. Qeyd:Başlıqsız göndərilən CV lərə baxılmayacaq Vakansiyalardan daha tez xəbərdar olmaq üçün Telegram kanalımıza abunə olun!';
// Sentence to be removed
                $removeSentence = 'Vakansiyalardan daha tez xəbərdar olmaq üçün Telegram kanalımıza abunə olun!';
                $desc = str_replace($removeSentence, '', $text);
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
                /*'mode' => $mode,
                'field' =>$field,
                'category' => $category,*/
                'education' => $education,
                'relevant_person' => $relevant_person,
                'email' => $email,
                'phone' => $phone,
                'start_day' => $start_date,
                'end_day' => $end_date,
                'desc' => $desc
            ];

            if (!empty($datas)) {
                $job_data_save = self::job_data_save($datas);
                return $job_data_save;
            } else {
                return $datas;
            }
        }
    }



    public static function job_data_save($datas)
    {

        $response = [];
        if (!empty($datas) && $datas != NULL) {
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
            $categories = Category::where('code', $categorycode)->first();

            if (empty($categories) && !empty($category)) {
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
                $sub_category = (!empty($datas['sub_category']) ? $datas['sub_category'] : NULL);
                $subcategorycode = (!empty($datas['sub_category']) ? mb_strtolower($datas['sub_category'], 'UTF-8') : NULL);
                $sub_categories = Category::where(['code' => $subcategorycode, 'parent_id' => $cat->id])->first();

                if (!empty($cat) && empty($sub_categories) && !empty($sub_category)) {
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
            $companies = Company::where('code', $companycode)->first();
            if (empty($companies) && $companycode != NULL) {
                $company = $datas['company'];
                $company_name = [$lang => $company];

                $companyDatas = new Company();
                $companyDatas->name = $company_name;
                $companyDatas->address = $company_name;
                $companyDatas->description = $company_name;
                $companyDatas->logo = '0';
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
                $response = [
                    'success' => false,
                    'message' => 'Type bazada olduqu üçün qeyde alinmadi.',
                    'code' => 422
                ];
            }

            $job_scrape_id = Job::where('scrape_id', $datas['scrape_id'])->first();
            if (empty($job_scrape_id)) {
                $title = [$lang => $datas['title']];
                $desc = [$lang => $datas['desc']];
                $seniority = [$lang => $datas['seniority']];

                $start_day = $datas['start_day'];
                list($startDay, $startMonth, $startYear) = explode(' ', $start_day);
                $monthTranslations = [
                    'Yanvar' => 'January',
                    'Fevral' => 'February',
                    'Mart' => 'March',
                    'Aprel' => 'April',
                    'May' => 'May',
                    'Iyun' => 'June',
                    'Iyul' => 'July',
                    'Avqust' => 'August',
                    'Sentyabr' => 'September',
                    'Oktyabr' => 'October',
                    'Noyabr' => 'November',
                    'Dekabr' => 'December',
                ];
                if (array_key_exists($startMonth, $monthTranslations)) {
                    $startCarbonDate = Carbon::createFromFormat('d F Y', $startDay . ' ' . $monthTranslations[$startMonth] . ' ' . $startYear, 'Asia/Baku');
                    $creDayFormattedDate = $startCarbonDate->format('d.m.Y');
                }

                $end_day = $datas['end_day'];
                list($endDay, $endMonth, $endYear) = explode(' ', $end_day);
                $monthTranslations = [
                    'Yanvar' => 'January',
                    'Fevral' => 'February',
                    'Mart' => 'March',
                    'Aprel' => 'April',
                    'May' => 'May',
                    'Iyun' => 'June',
                    'Iyul' => 'July',
                    'Avqust' => 'August',
                    'Sentyabr' => 'September',
                    'Oktyabr' => 'October',
                    'Noyabr' => 'November',
                    'Dekabr' => 'December',
                ];
                if (array_key_exists($endMonth, $monthTranslations)) {
                    $startCarbonDate = Carbon::createFromFormat('d F Y', $endDay . ' ' . $monthTranslations[$endMonth] . ' ' . $endYear, 'Asia/Baku');
                    $upFormattedDate = $startCarbonDate->format('d.m.Y');
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
                $job->logo = 'null.png';
                $job->status = 1;
                $job->created_at = (!empty($creDayFormattedDate) ? $creDayFormattedDate : NULL);
                $job->updated_at = (!empty($upFormattedDate) ? $upFormattedDate : NULL);
                $job->save();
            }
            return $response;
        } else {
            return [
                'success' => false,
                'message' => 'Məlumat boş olduqu üçün bazaya heçnə yazılmadı.',
                'code' => 422
            ];
        }
    }
}
