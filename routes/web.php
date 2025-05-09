<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserCompany;
use Spatie\Analytics\Period;
use Illuminate\Support\Facades\Request;
/*$ip = Request::ip();
if (!in_array($ip,['162.158.210.70'])) {
    Route::get('/', function(){
        return view('web.comingsoon');
    });
}else{*/

Route::get('/test', function () {
    $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(1));
    dd($analyticsData);
});

/*Route::get('/linkedin/authorize', function () {
    return redirect()->to('https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' . config('services.linkedin.client_id') . '&redirect_uri=https://isveren.az/linkedin/callback&scope=w_member_social+rw_organization_admin+w_organization_social');
})->name('linkedin.authorize');*/
Route::get('/linkedin/authorize', function () {
    $clientId = config('services.linkedin.client_id');
    $redirectUri = urlencode(config('services.linkedin.redirect_uri')); // URL-encoded

    $scopes = 'w_member_social'; // İhtiyaç duyulan izinler

    $url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code"
        . "&client_id={$clientId}"
        . "&redirect_uri={$redirectUri}"
        . "&scope={$scopes}";
    return redirect()->to($url);
})->name('linkedin.authorize');



Route::get('/linkedin/callback', 'HomeController@handleCallback')->name('linkedin.callback');
Route::get('/cv/vacancies', 'HomeController@apiVacancy')->name('api.vacancy');


Route::get('/yandex_bc8fb0df268254a0.html', function () {
    return response()->view('yandex_verification')->header('Content-Type', 'text/html');
});

Route::post('/job/search', 'HomeController@search')->name('job.search');
Route::get('/job/search', 'HomeController@search');

Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap.index');
Route::get('/sitemap', 'SitemapController@dayResult')->name('sitemap.dayResult');
Route::get('/company.xml', 'SitemapController@company')->name('sitemap.company');
Route::get('/professions-sitemap.xml', 'SitemapController@profession')->name('sitemap.index');


Route::get('/sitemap-years.xml', 'SitemapController@years')->name('sitemap.years');
Route::get('/sitemap-months-{year}.xml', 'SitemapController@months')->name('sitemap.months');
Route::get('/sitemap-days-{year}-{month}.xml', 'SitemapController@days')->name('sitemap.days');

Route::get('/scrape/{website}', 'ScrapingController@data');

Route::get('/', 'HomeController@home')->name('web.home');
Route::get('/vacancies', 'HomeController@vacancy')->name('web.vacancy');
Route::get('/about', 'HomeController@about')->name('web.about');
Route::get('/rules', 'HomeController@rules')->name('web.rules');
Route::get('/advertising', 'HomeController@advertising')->name('web.advertising');
Route::get('/contact', 'HomeController@contact')->name('web.contact');
Route::post('/job-contact', 'Users\AuthController@jobContact')->name('web.jobContact');
Route::post('/contactform', 'HomeController@contactform')->name('web.contactform');

Route::get('/follower', 'HomeController@follower')->name('web.follower');
Route::get('/api', 'HomeController@home')->name('web.scroll');

Route::get('/job-details/{slug}', 'HomeController@jobDetails')->name('web.job-details');
Route::post('/ho', 'HomeController@index')->name('web.search');


Route::get('/companies', 'HomeController@companies')->name('web.companies');
Route::get('/api-companies', 'HomeController@companies')->name('web.scrollCompanies');
Route::get('/company-details/{id}', 'HomeController@companyDetails')->name('web.company-details');

Route::get('/blogs', 'HomeController@blogs')->name('web.blogs');
Route::get('/api-blogs', 'HomeController@blogs')->name('web.scrollBlogs');
Route::get('/blog-details/{id}', 'HomeController@blogDetails')->name('web.blogs-details');

Route::get('/cv', 'HomeController@cv')->name('web.cv');
Route::get('/api-cv', 'HomeController@cv')->name('web.scrollCv');
Route::get('/cv-details/{slug}/{id}', 'HomeController@cvDetails')->name('web.cv-details');
Route::get('/cv/download/{id}', 'HomeController@downloadCv')->name('web.cvPdf');

Route::get('/professions', 'HomeController@professions')->name('web.professions');
Route::get('/autocomplete', 'HomeController@autocomplete')->name('web.autocomplete');

Route::post('/interact', 'HomeController@interact');



Route::get('/sub-category/{id}', 'HomeController@subCategory');
//start login and register
Route::get('/captcha', 'Users\AuthController@generateCaptcha')->name( 'web.generateCaptcha');
Route::get('/register/user-activity/{id}', 'Users\AuthController@userStatus')->name('web.register.userStatus');
Route::get('/register/company-activity/{id}', 'Users\AuthController@companyStatus')->name('web.register.companyStatus');

Route::get('auth/company-google', 'Users\SocialController@redirectToCompanyGoogle');
Route::get('auth/company-google/callback', 'Users\SocialController@handleCompanyGoogleCallback');
Route::get('auth/user-google', 'Users\SocialController@redirectToUserGoogle');
Route::get('auth/google/callback', 'Users\SocialController@handleUserGoogleCallback');
Route::get('auth/facebook', 'Users\SocialController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Users\SocialController@handleFacebookCallback');

Route::get('/register', 'Users\AuthController@register')->name('web.register');
Route::post('/user-register-accept', 'Users\AuthController@userRegisterAccept')->name('web.userRegisterAccept');
Route::post('/company-register-accept', 'Users\AuthController@companyRegisterAccept')->name('web.companyRegisterAccept');
Route::get('/login', 'Users\AuthController@login')->name('web.login');
Route::post('/user-login-accept', 'Users\AuthController@userLoginAccept')->name('web.userLoginAccept');
Route::post('/company-login-accept', 'Users\AuthController@companyLoginAccept')->name('web.companyLoginAccept');
//end login and register

Route::middleware([UserCompany::class])->group(function () {
    //ajax
    Route::get('/user/subcategory/{id}', 'Users\JobController@subCategory')->name('web.user.jobs.subCategory');
    //end ajax

    Route::get('/logout', 'Users\AuthController@logout')->name('web.user.logout');
    Route::get('/user/account', 'Users\UsersController@dashboard')->name('web.user.dashboard');
    Route::get('/user/settings', 'Users\UsersController@settings')->name('web.user.settings');
    Route::put('/user/settings_update/{id}', 'Users\UsersController@settings_update')->name('web.user.settings_update');

    //start company
    Route::get('/user/jobs/list', 'Users\JobController@index')->name('web.user.jobs.list');
    Route::get('/user/jobs/create', 'Users\JobController@create')->name('web.user.jobs.create');
    Route::post('/user/jobs/store', 'Users\JobController@store')->name('web.user.jobs.store');
    Route::get('/user/jobs/edit/{id}', 'Users\JobController@edit')->name('web.user.jobs.edit');
    Route::put('/user/jobs/update/{id}', 'Users\JobController@update')->name('web.user.jobs.update');
    Route::delete('/user/jobs/delete/{id}', 'Users\JobController@destroy')->name('web.user.jobs.destroy');

    Route::get('/user/company/list', 'Users\CompanyController@index')->name('web.user.company.list');
    Route::get('/user/company/create', 'Users\CompanyController@create')->name('web.user.company.create');
    Route::post('/user/company/store', 'Users\CompanyController@store')->name('web.user.company.store');
    Route::get('/user/company/edit/{id}', 'Users\CompanyController@edit')->name('web.user.company.edit');
    Route::put('/user/company/update/{id}', 'Users\CompanyController@update')->name('web.user.company.update');
    Route::delete('/user/company/delete/{id}', 'Users\CompanyController@destroy')->name('web.user.company.destroy');
    Route::get('/company/appeal', 'Users\UsersController@companyAppeal')->name('web.company.appeal');
    //end company

    //start user
    Route::get('/user/cv', 'Users\CvController@list')->name('web.user.cv');
    Route::get('/user/cv/cities', 'Users\CvController@cities')->name('web.user.cv.cities');
    Route::get('/user/cv/parent-categories', 'Users\CvController@parentCategory')->name('web.user.cv.parentCategory');
    Route::post('/user/cv/store', 'Users\CvController@store')->name('web.user.cv.store');
    Route::put('/user/cv/update/{id}', 'Users\CvController@update')->name('web.user.cv.update');
    Route::post('/remove-skill', 'Users\CvController@removeSkill');
    Route::post('/remove-language', 'Users\CvController@removeLanguage');
    Route::post('/remove-experience', 'Users\CvController@removeExperience');
    Route::post('/remove-education', 'Users\CvController@removeEducation');
    Route::post('/remove-project', 'Users\CvController@removeProject');
    Route::post('/remove-hobby', 'Users\CvController@removeHobby');
    Route::post('/remove-social', 'Users\CvController@removeSocial');

    Route::get('/user/followers', 'Users\UsersController@follower')->name('web.user.follower');
    Route::get('/user/appeal', 'Users\UsersController@userAppeal')->name('web.user.appeal');
    //end user

    Route::get('/user/sub-category/{id}', 'Users\UsersController@subCategory')->name('web.sub-category');
});
//}

