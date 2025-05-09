<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Repositories\TranslationRepositoryImpl;
use Illuminate\Http\Request;

class SiteWordsController extends Controller
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
        $translations = Translation::where('status', 1)->get();
        return view('admin.site-words.index', compact('translations'));
    }

    public function edit($code)
    {
        $translation = Translation::where(['status' => 1, 'code' => $code])->first();

        if (!empty($translation)) {
            $words = lang_path() . "/" . $code . "/web.php";
            $siteStatisticsData = include $words;
        }
        return view('admin.site-words.edit', compact('translation', 'siteStatisticsData'));
    }

    public function update($code, Request $request)
    {
        $translation = Translation::where(['status' => 1, 'code' => $code])->first();

        if (!empty($translation)) {
            $words = lang_path() . "/" . $code . "/web.php";
            $siteStatisticsData = include $words;
            foreach ($request->all() as $key => $value) {
                if (!empty($siteStatisticsData[$key])) {
                    $siteStatisticsData[$key] = $value;
                }
            }
            $result = file_put_contents($words, '<?php return ' . var_export($siteStatisticsData, true) . ';');
            if (!empty($result)) {
                return redirect()->back()->with('success', "Dosya başarıyla kaydedildi." . $result);
            } else {
                return redirect()->back()->with('errors', "Dosya kaydedilirken bir hata oluştu:" . $result);
            }
        }
        return redirect()->back()->with('errors', "Netice yox");
    }
}
