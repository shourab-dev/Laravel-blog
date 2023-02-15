<?php

namespace App\Http\Controllers\frontend;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {

        return view('frontend.home');
    }


    public function showCategoryPost($slug)
    {

        $category = Category::where('slug', $slug)->first();
        $posts = Post::where('category_id', $category->id)->with('user')->paginate(10);

        return view('frontend.categoryShow', compact('category', 'posts'));
    }

    public function showSubCategoryPost($slug)
    {
        $category = SubCategory::where('slug', $slug)->first();

        $posts = Post::where('sub_category_id', $category->id)->with('user')->paginate(10);

        return view('frontend.categoryShow', compact('category', 'posts'));
    }


    public function showPost($slug)
    {
        $post = Post::with(['category', 'user', 'tags'])->where('slug', $slug)->first();
        // dd($post);
        return view('frontend.singleBlog', compact('post'));
    }



    public function searchLive(Request $request)
    {
        $post = Post::where('title', 'LIKE', '%' . $request->searchText . '%')->get();
        if ($post->count() == 0) {
            return response('no post found!!', 404);
            exit();
        }
        return json_encode($post);
    }
}
