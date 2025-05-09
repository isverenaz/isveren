<?php

use App\Http\Middleware\Admin;
//use App\Http\Middleware\AdminAccess;
use \Illuminate\Support\Facades\Route;
/*$ip = Request::ip();
if (!in_array($ip,['162.158.210.70'])) {
    Route::get('/', function(){
        return view('web.comingsoon');
    });
}else{*/
Route::get('/login', 'LoginController@login')->name('login');
Route::post('/login', 'LoginController@loginAccept');

Route::middleware([Admin::class])->name('admin.')->group(function () {
    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::get('/site-words', 'SiteWordsController@index')->name('site-words.index');
    Route::get('/site-words/{code}', 'SiteWordsController@edit')->name('site-words.edit');
    Route::put('/site-words/update/{code}', 'SiteWordsController@update')->name('site-words.update');

    Route::get('/home', 'HomeController@home')->name('home');
    Route::get('/contact', 'HomeController@contact')->name('contact');

    // City Routes
    Route::get('/city/index', 'CityController@index')->name('city.index');
    Route::get('/city/create', 'CityController@create')->name('city.create');
    Route::post('/city/create', 'CityController@store');
    Route::get('/city/edit/{id}', 'CityController@edit')->name('city.edit');
    Route::delete('/city/delete/{id}', 'CityController@destroy')->name('city.destroy');
    Route::post('/city/edit/{id}', 'CityController@update');
    Route::get('/city/search', 'CityController@search');

    // Categories Routes
    Route::get('/category/index', 'CategoryController@index')->name('category.index');
    Route::get('/category/create', 'CategoryController@create')->name('category.create');
    Route::post('/category/create', 'CategoryController@store');
    Route::get('/category/edit/{id}', 'CategoryController@edit')->name('category.edit');
    Route::get('/category/sub-category/{id}', 'CategoryController@subCategory')->name('category.sub-category');
    Route::post('/category/edit/{id}', 'CategoryController@update');
    Route::delete('/category/delete/{id}', 'CategoryController@destroy')->name('category.destroy');

    //Translation Routes
    Route::resource('translations', 'TranslationsController');
    Route::post('translations/status/{id}', 'TranslationsController@status')->name('translations.status');

    //JobType Routes
    Route::resource('job-type', 'JobTypeController');
    Route::post('job-type/status/{id}', 'JobTypeController@status')->name('job-type.status');

    //Company
    Route::resource('company', 'CompanyController');
    Route::post('company/status/{id}', 'CompanyController@status')->name('company.status');


    //Role Routes
    Route::resource('role', 'RoleController');

    //Permission Routes
    Route::resource('permission', 'PermissionController');

    //Auth Routes
    Route::resource('user', 'AuthController');

    Route::resource('jobs', 'JobController');
    Route::post('jobs/status/{id}', 'JobController@status')->name('jobs.status');

    Route::resource('blogs', 'BlogController');
    Route::post('blogs/status/{id}', 'BlogController@status')->name('blogs.status');

    Route::resource('cv', 'CvController');
    Route::post('cv/status/{id}', 'CvController@status')->name('cv.status');

    Route::resource('static-pages', 'StaticPagesController');
});
//}