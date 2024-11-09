<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::active()->with('images')->latest()->paginate(9);
        $mostThreeViewdPosts = Post::active()->orderBy('num_of_views', 'desc')->limit(3)->get();
        $oldestNews = Post::active()->oldest()->take(3)->get();
        $gretestPostComments = Post::active()->withCount('comments')->orderBy('comments_count', 'desc')->take(3)->get();

        // i need with each category get 4 posts only so i use map
        $categories = Category::has('posts','>',2)->where('status',1)->get(); // categories that have 2 posts at least to show
        $categories_with_posts = $categories->map(function ($category) {
            // i need to add new key to category object called posts and that key contains 4 posts of that category
            $category->posts = $category->posts()->active()->limit(4)->get();
            return $category;
        });
        return view('frontend.index', compact('posts', 'mostThreeViewdPosts', 'categories_with_posts','oldestNews', 'gretestPostComments'));
    }
}
