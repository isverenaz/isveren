<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserCompany;
use Spatie\Analytics\Period;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(1));
    dd($analyticsData);
});

Route::get('/check-login', function () {
    return response()->json([
        'isLoggedIn' => Auth::check(),
    ]);
})->name('web.checkLogin');

Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap.index');
Route::get('/sitemap', 'SitemapController@dayResult')->name('sitemap.dayResult');
Route::get('/company.xml', 'SitemapController@company')->name('sitemap.company');


Route::get('/sitemap-years.xml', 'SitemapController@years')->name('sitemap.years');
Route::get('/sitemap-months-{year}.xml', 'SitemapController@months')->name('sitemap.months');
Route::get('/sitemap-days-{year}-{month}.xml', 'SitemapController@days')->name('sitemap.days');


Route::get('/scrape/{website}', 'ScrapingController@data');

Route::get('/', 'HomeController@home')->name('web.home');
Route::get('/about', 'HomeController@about')->name('web.about');
Route::get('/cv', 'CvController@index')->name('web.cv');
Route::get('/contact', 'HomeController@contact')->name('web.contact');
Route::post('/contactform', 'HomeController@contactform')->name('web.contactform');

Route::get('/follower', 'HomeController@follower')->name('web.follower');
Route::get('/api', 'HomeController@home')->name('web.scroll');

Route::get('/job-details/{id}', 'HomeController@jobDetails')->name('web.job-details');
Route::post('/ho', 'HomeController@index')->name('web.search');


Route::get('/companies', 'HomeController@companies')->name('web.companies');
Route::get('/api-companies', 'HomeController@companies')->name('web.scrollCompanies');
Route::get('/company-details/{id}', 'HomeController@companyDetails')->name('web.company-details');



Route::post('/register', 'Users\AuthController@register')->name('web.register');
Route::post('/login', 'Users\AuthController@login')->name('web.login');

Route::post('/interact', 'HomeController@interact');

Route::post('/register', 'Users\AuthController@register')->name('web.register');
Route::post('/login', 'Users\AuthController@login')->name('web.login');
Route::middleware([UserCompany::class])->group(function () {
    Route::get('/logout', 'Users\AuthController@logout')->name('web.user.logout');
    Route::get('/user/dashboard', 'Users\UsersController@dashboard')->name('web.user.dashboard');
    Route::get('/user/settings/{id}', 'Users\UsersController@settings')->name('web.user.settings');
    Route::get('/user/followers', 'Users\UsersController@follower')->name('web.user.follower');
    Route::put('/user/settings_update/{id}', 'Users\UsersController@settings_update')->name('web.user.settings_update');

    Route::get('/user/jobs/list', 'Users\JobController@index')->name('web.user.jobs.list');
    Route::get('/user/jobs/create', 'Users\JobController@create')->name('web.user.jobs.create');
    Route::post('/user/jobs/store', 'Users\JobController@store')->name('web.user.jobs.store');
    Route::get('/user/jobs/edit/{id}', 'Users\JobController@edit')->name('web.user.jobs.edit');
    Route::put('/user/jobs/update/{id}', 'Users\JobController@update')->name('web.user.jobs.update');

    Route::get('/user/company/list', 'Users\CompanyController@index')->name('web.user.company.list');
    Route::get('/user/company/create', 'Users\CompanyController@create')->name('web.user.company.create');
    Route::post('/user/company/store', 'Users\CompanyController@store')->name('web.user.company.store');
    Route::get('/user/company/edit/{id}', 'Users\CompanyController@edit')->name('web.user.company.edit');
    Route::put('/user/company/update/{id}', 'Users\CompanyController@update')->name('web.user.company.update');

    Route::get('/user/job-seekers/list', 'Users\JobSeekerController@index')->name('web.user.job-seekers.list');
    Route::get('/user/job-seekers/create', 'Users\JobSeekerController@create')->name('web.user.job-seekers.create');
    Route::post('/user/job-seekers/store', 'Users\JobSeekerController@store')->name('web.user.job-seekers.store');
    Route::get('/user/job-seekers/edit/{id}', 'Users\JobSeekerController@edit')->name('web.user.job-seekers.edit');
    Route::put('/user/job-seekers/update/{id}', 'Users\JobSeekerController@update')->name('web.user.job-seekers.update');


    Route::get('/user/sub-category/{id}', 'Users\JobSeekerController@subCategory')->name('web.sub-category');


});
