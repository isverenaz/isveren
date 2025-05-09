<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Repositories\CityRepositoryImpl;
use App\Http\Requests\CityStoreRequest;
use App\Services\SearchEngine;
use App\Models\City;
use App\Helpers\CityHelper;

class CityController extends Controller
{
    protected $cityRepository;

    public function __construct(CityRepositoryImpl $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        $cities = $this->cityRepository->getAll();
        return view('admin.city.index', compact('cities'));
    }

    public function create()
    {
        $locales = Translation::where('status',1)->get();
        return view('admin.city.create',compact('locales'));
    }

    public function search()
    {
        $searchEngine = SearchEngine::getInstance();
        $searchColumns = ['name'];
        $results = $searchEngine->search(new City, 'sdsc', $searchColumns);
        return $results;
    }

    public function store(CityStoreRequest $request)
    {
        try {
            $user = $request->user('customer');

            if ($user && $user->can('create-tasks')) {
                $cityData = CityHelper::prepareCityData($request);

                if ($this->cityRepository->create($cityData)) {
                    return redirect()->route('admin.city.index')
                        ->with('success', 'Şəhər adı uğurla əlavə edildi');
                } else {
                    return back()->with('error', 'Şəhər yaradılmadı.');
                }
            } else {
                return back()->with('error', 'Bu işlemi gerçekleştirmek için yetkiniz yok.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $city =  City::findOrFail($id);
        $locales = Translation::where('status',1)->get();
        return view('admin.city.edit', compact('city','locales'));
    }

    public function update(CityStoreRequest $request, $id)
    {
        try {
            $cityData = CityHelper::prepareCityData($request);

            if ($this->cityRepository->update($id, $cityData)) {
                return redirect()->route('admin.city.index')
                    ->with('success', 'Şəhər adı uğurla dəyişdirildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $data = City::where('id',$id)->first();
            if (!empty($data))
            {
                $id = $data->id;
                $this->cityRepository->delete($id);
                $message = 'Məlumat silindi.';
            }else{
                $message = 'Məlumatın tapilmadiqi üçün silinmədi.';
            }
            return redirect()->back()->with('success', $message);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Xətta baş verdi.-'.$exception->getMessage());
        }
    }
}
