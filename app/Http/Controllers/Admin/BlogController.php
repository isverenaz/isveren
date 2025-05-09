<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BlogHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Translation;
use App\Models\User;
use App\Repositories\BlogRepositoryImpl;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    protected $blogRepository;

    public function __construct(BlogRepositoryImpl $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }


    public function index(Request $request)
    {
        $status = $request['status'];
        $blogs = $this->blogRepository->getAll($status);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::where('status',1)->orderBy('name', 'ASC')->get();
        $locales = Translation::where('status',1)->get();
        return view('admin.blogs.create', compact( 'categories',  'locales'));
    }

    public function status($id, Request $request)
    {
        $status = $request->status;
        $updated = Blog::where('id', $id)->update(['status' => !$status]);

        if (isset($updated) && !empty($updated)) {
            return true;
        } else {
            return false;
        }
    }

    public function store(BlogRequest $blogRequest)
    {
        try {
            $guard = 'customer';
            $blogImage =null;
            $blogData = BlogHelper::blogData($blogRequest,$guard,$blogImage);
            $data = $this->blogRepository->create($blogData);
            if ($data) {
                return redirect()->route('admin.blogs.index')->with('success', 'Blog uğurla əlavə edildi');
            }else{
                return redirect()->route('admin.blogs.index')->with('success', 'Blog uğurla əlavə edilmədi');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.blogs.index')->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function show(Blog $blog)
    {
        //
    }

    public function edit($id)
    {
        $blog = Blog::with('jobcategory')->where('id', $id)->first();
        $categories = Category::where('status',1)->orderBy('name', 'ASC')->get();
        $locales = Translation::where('status',1)->get();
        return view('admin.blogs.edit', compact('blog',  'categories', 'locales'));
    }

    public function update($id,BlogRequest $blogRequest)
    {
        try {
            $blogImage = Blog::where('id',$id)->first();
            $guard = 'customer';
            $blogData = BlogHelper::blogData($blogRequest,$guard,$blogImage);
            if ($this->blogRepository->update($id, $blogData)) {
                return redirect()->route('admin.blogs.index')->with('success', 'Blog uğurla dəyişdirildi');
            }else{
                return redirect()->route('admin.blogs.index')->with('success', 'Blog uğurla dəyişdirilmədi');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.blogs.index')->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::where('id',$id)->first();
            $id = $blog->id;
            $this->blogRepository->delete($id);
            $message = 'Məlumat silindi.';

            return redirect()->route('admin.blogs.index')->with('success', $message);
        } catch (\Exception $exception) {
            return redirect()->route('admin.blogs.index')->with('error', 'Xətta baş verdi.-'.$exception->getMessage());
        }
    }
}
