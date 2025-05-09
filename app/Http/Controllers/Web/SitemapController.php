<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Spatie\Sitemap\Sitemap;


class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('web.job-sitemap')->header('Content-Type', 'text/xml');
    }

    public function dayResult()
    {
        // $jobs = Job::whereDate('created_at', Carbon::today()->toDateString())->get();

        $today = Carbon::today();

        // Bugünün yıl, ay ve gün bilgilerini alır
        $year = $today->year;
        $month = $today->month;
        $day = $today->day;
        // dd($bugununAyı);

        // Bulunduğunuz yılın, ayın ve bulunduğunuz günün verilerini getirir
        $jobs = Job::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereDay('created_at', $day)
            ->get();

        // $jobs değişkenini kontrol edin


        // Sitemap içeriğini oluştur
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' .
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($jobs as $job) {
            $lastmod = $job->updated_at ? $job->updated_at->toIso8601String() : now()->toIso8601String();

            $sitemap .= '<url>' .
                '<loc>' . route('web.job-details', $job->id) . '</loc>' .
                '<lastmod>' . $lastmod . '</lastmod>' .
                '<changefreq>monthly</changefreq>' .
                '<priority>0.8</priority>' .
                '</url>';
        }

        $sitemap .= '</urlset>';

        // Sitemap içeriğini HTTP yanıtı olarak döndür
        return response($sitemap)->header('Content-Type', 'text/xml');
    }



    public function years()
    {
        $years = Job::selectRaw('YEAR(updated_at) year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' .
            '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($years as $year) {
            $sitemap .= '<sitemap>' .
                '<loc>' . route('sitemap.months', ['year' => $year]) . '</loc>' .
                '</sitemap>';
        }

        $sitemap .= '</sitemapindex>';

        return response($sitemap)->header('Content-Type', 'text/xml');
    }

    public function months($year)
    {

        // /sitemap-months-{year}.xml isteği için sitemap oluştur
        $months = Job::selectRaw('MONTH(created_at) as month')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->pluck('month');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' .
            '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($months as $month) {
            $sitemap .= '<sitemap>' .
                '<loc>' . route('sitemap.days', ['year' => $year, 'month' => $month]) . '</loc>' .
                '</sitemap>';
        }

        $sitemap .= '</sitemapindex>';

        return response($sitemap)->header('Content-Type', 'text/xml');
    }

    public function days($year, $month)
    {
        $jobs = Job::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' .
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($jobs as $job) {
            $lastmod = $job->created_at ? $job->created_at->format('c') : now()->format('c');

            $sitemap .= '<url>' .
                '<loc>' . route('web.job-details', $job->id) . '</loc>' .
                '<lastmod>' . $lastmod . '</lastmod>' .
                '<changefreq>monthly</changefreq>' .
                '<priority>0.8</priority>' .
                '</url>';
        }

        $sitemap .= '</urlset>';

        return response($sitemap)->header('Content-Type', 'text/xml');
    }

    public function company()
    {
        $companies = Company::get();

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' .
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($companies as $company) {
            $sitemap .= '<url>' .
                '<loc>' . route('web.company-details', ['id' => $company->id]) . '</loc>' .
                '<lastmod>' . $company->updated_at->tz('UTC')->toAtomString() . '</lastmod>' .
                '</url>';
        }

        $sitemap .= '</urlset>';

        return response($sitemap)->header('Content-Type', 'text/xml');
    }


    public function profession()
    {
        $jobs = Job::all();
        $azAlphabet = ['A', 'B', 'C', 'Ç', 'D', 'E', 'Ə', 'F', 'G', 'H', 'X', 'İ', 'J', 'K', 'Q', 'L', 'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'];

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // ixtisaslar sayfası
        foreach ($azAlphabet as $char) {
            $content .= '<url>';
            $content .= '<loc>' . url('/professions?index=' . $char) . '</loc>';
            $content .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $content .= '<changefreq>weekly</changefreq>';
            $content .= '<priority>0.8</priority>';
            $content .= '</url>';
        }

        // Job detay sayfaları
        foreach ($jobs as $job) {
            $content .= '<url>';
            $content .= '<loc>' . route('web.job-details', $job->id) . '</loc>';
            $content .= '<lastmod>' . $job->updated_at->toAtomString() . '</lastmod>';
            $content .= '<changefreq>weekly</changefreq>';
            $content .= '<priority>0.8</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
