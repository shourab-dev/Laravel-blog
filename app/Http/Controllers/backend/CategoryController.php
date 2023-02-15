<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory()
    {
        $categories  = Category::with('subcategories')->latest()->get();
        

        return view('backend.category.addCategory', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        //*VALIDATION RULES
        $request->validate([
            'title' => 'required|string',
        ], [
            'title.required' => 'Please enter a Category Title',

        ]);


        //*STORING PORTION

        $category = new Category();
        $category->title = $request->title;
        $category->slug = $this->slugGenerator($request->title, $request->slug);
        $category->save();
        return back();
    }

    public function editCategory(Category $category)
    {
        $editedCategory = $category;
        $categories  = Category::latest()->get();
        return view('backend.category.addCategory', compact('categories', 'editedCategory'));
    }


    public function updateCategory(Request $request, Category $category)
    {

        dd($category);
        //*VALIDATION RULES
        $request->validate([
            'title' => 'required|string',
        ], [
            'title.required' => 'Please enter a Category Title',

        ]);


        $category->title = $request->title;
        $category->slug = $this->slugGenerator($request->title, $request->slug);
        $category->save();
        return redirect()->route('category.add');
    }


    public function deleteCategory(Category $category)
    {
        $category->delete();
        return back();
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
}
