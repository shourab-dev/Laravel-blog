<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function addSubcategory()
    {
        $subcategories = SubCategory::with('category')->latest()->get();

        $categories = Category::select('id', 'title')->get();





        return view('backend.category.addSubCategory', compact('subcategories', 'categories'));
    }


    public function storeSubCategory(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required'
        ]);

        //*VALIDATION DONE
        $subCategory = new SubCategory();
        $subCategory->title = $request->title;
        $subCategory->slug = $this->slugGenerator($request->title, $request->slug);
        $subCategory->category_id = $request->category_id;
        $subCategory->save();
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

    public function deleteSubCategory(SubCategory $subCat)
    {
        $subCat->delete();
        return back();
    }
}
