<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\TranslationRepository;
use App\Helpers\TranslationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TranslationsRequest;
use App\Models\Translation;
use App\Repositories\TranslationRepositoryImpl;
use App\Services\SearchEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class TranslationsController extends Controller
{

    protected $translationRepository;

    public function __construct(TranslationRepositoryImpl $translationRepository)
    {
        $this->translationRepository = $translationRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $translations = $this->translationRepository->getAll();
        return view('admin.translations.index', compact('translations'));
    }


    public function search()
    {
        $searchEngine = SearchEngine::getInstance();
        $searchColumns = ['name'];
        $results = $searchEngine->search(new Translation, 'sdsc', $searchColumns);
        return $results;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.translations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TranslationsRequest $translationsRequest)
    {
        try {
            $translationData = TranslationHelper::prepareTranslationData($translationsRequest);
            if ($this->translationRepository->create($translationData)) {
                return redirect()->back()->with('success', Lang::get('admin.success'));
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('errors', $exception->getMessage());
        }
    }


    public function status($id, Request $request)
    {
//        dd($id);
        $status = $request->status;
        $updated = Translation::where('id', $id)->update(['status' => !$status]);

        if (isset($updated) && !empty($updated)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function show(Translation $translation)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function edit(Translation $translation)
    {
        return view('admin.translations.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Translation $translation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Translation $translation)
    {
        //
    }
}
