<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CategoryHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Translation;
use App\Repositories\CategoryRepositoryImpl;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryImpl $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAll();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $locales = Translation::where('status',1)->get();
        return view('admin.category.create', compact('categories','locales'));
    }

    public function store(CategoryRequest $request)
    {

        try {
            $categoryData = CategoryHelper::prepareCategoryData($request);
            if ($this->categoryRepository->create($categoryData)) {
                return redirect()->route('admin.category.index')->with('success', 'Kategoriya adı uğurla əlavə edildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $locales = Translation::where('status',1)->get();
        return view('admin.category.edit', compact('category','locales'));
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $categoryData = CategoryHelper::prepareCategoryData($request);
            if ($this->categoryRepository->update($id, $categoryData)) {
                return redirect()->route('admin.category.index')->with('success', 'Kategoriya adı uğurla əlavə edildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $data = Category::where('id',$id)->first();
            if (!empty($data))
            {
                $id = $data->id;
                $this->categoryRepository->delete($id);
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
