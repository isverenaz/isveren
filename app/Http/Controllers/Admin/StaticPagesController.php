<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StaticPageHelper;
use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaticPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $static_pages = StaticPage::orderBy('id','DESC')->get();
        return view('admin.static-pages.index',compact('static_pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locales = Translation::where('status',1)->get();
        return view('admin.static-pages.create',compact('locales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = StaticPageHelper::prepareStaticData($request);
            StaticPage::create($data);

            return redirect()->route('admin.static-pages.index')->with('success', 'Sehife uğurla əlavə edildi');
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function show(StaticPage $staticPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function edit($id,StaticPage $staticPage)
    {
        $staticPage = StaticPage::findOrFail($id);
        $locales = Translation::where('status',1)->get();
        return view('admin.static-pages.edit',compact('locales','staticPage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaticPage $staticPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaticPage $staticPage)
    {
        //
    }
}
