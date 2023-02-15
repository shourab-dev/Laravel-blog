<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Spatie\Tags\Tag;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function addPost()
    {


        $categories = Category::latest()->get();
        $subCategories = SubCategory::latest()->get();
        return view('backend.post.addPost', compact('categories', 'subCategories'));
    }



    public function storePost(Request $request)
    {
        // dd($request->all());

        // Tag::findOrCreate(['name' => $request->hash_tag]);



        $post = new Post();
        $post->user_id  =  auth()->user()->id;
        $post->category_id = $request->category_id;
        $post->sub_category_id = $request->subCategory_id;
        $post->title = $request->title;
        $post->slug = $this->slugGenerator($request->title);
        $post->type = $request->type;
        if ($request->hasFile('featured')) {
            $post->featured_img = $this->imageUpload($request);
        }
        $post->content = $request->content;
        $post->save();

        $tagsArray = str($request->hash_tag)->explode(',');
        foreach ($tagsArray as $tag) {
            $hash_tag =  Tag::findOrCreate(['name' => trim($tag)]);
            $post->attachTag($hash_tag);
        }


        return back();
    }


    public function allPosts()
    {
        $posts = Post::where('user_id', auth()->user()->id)->get();
        return view('backend.post.allPost',compact('posts'));
    }






    private function slugGenerator($title, $slug = null)
    {

        if ($slug == null) {
            $newSlug  = str()->slug($title);
        } else {
            $newSlug = str()->slug($slug);
        }
        $count  = Category::where('slug', 'LIKE', '%' . $newSlug . '%')->count();
        if ($count > 0) {
            $newSlug = $newSlug . '-' . $count++;
        }

        return $newSlug;
    }

    private function imageUpload($request)
    {
        if ($request->hasFile('featured')) {
            $ext = $request->featured->extension();
            $fileName = $this->slugGenerator($request->title) . '.' . $ext;
            $image = $request->featured->storeAs('uploads', $fileName, 'public');
            return $image;
        }
    }
}
