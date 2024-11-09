<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    {
        // dd(1);
        $category=Category::whereSlug($slug)->first();
        $otherCategories=Category::where('slug','!=',$slug)->get();

        $posts=$category->posts()->active()->paginate(9);
        // dd($posts);
        return view('frontend.categoryPosts',compact('posts','otherCategories','category'));
    }
}
