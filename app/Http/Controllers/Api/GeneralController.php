<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Admin;
use App\Models\Autherization;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\RelativeSite;
use App\Models\Setting;
use App\Notifications\NewContactNotify;
use Illuminate\Http\Request;
use Notification;

class GeneralController extends Controller
{
    public function getPosts()
    {
        // return request()->query('keyword'); //to get parmters after ?
        $query = Post::query()->with([
            'images',
            'user',
            'category'
        ])->whereHas('user', function ($q) {
            $q->where('status', 1);
        })->whereHas('category', function ($q) {
            $q->where('status', 1);
        })->active();
        if (request()->query('keyword')) {
            $query->where('title', 'like', '%' . request()->query('keyword') . '%');
        }
        //this for if we make the admin can create posts
        // $query = Post::query()->with([
        //     'images',
        //     'user',
        //     'category'
        // ])->where(function ($q) {
        //     $q->whereHas('user', function ($q) {
        //         $q->where('status', 1);
        //     })->orwhere('user_id', null);
        // })->whereHas('category', function ($q) {
        //     $q->where('status', 1);
        // })->active();
        //we use clone to make each querey seprate from each other as if we get 4 postes as a varable 4postes then other varable called all posts the output will be 4 posts also so we use clone
        $posts = clone $query->latest()->paginate(9);
        $latest_posts = clone $query->latest()->take(4)->get();

        // i need with each category get 4 posts only so i use map
        $categories = Category::has('posts', '>', 2)->where('status', 1)->get(); // categories that have 2 posts at least to show
        $categories_with_posts = $categories->map(function ($category) {
            // i need to add new key to category object called posts and that key contains 4 posts of that category
            $category->posts = $category->posts()->active()->limit(4)->get();
            return $category;
        });
        $mostThreeViewdPosts = clone $query->orderBy('num_of_views', 'desc')->limit(3)->get();
        $oldestNews = clone $query->oldest()->take(3)->get();
        $gretestPostComments = clone $query->withCount('comments')->orderBy('comments_count', 'desc')->take(3)->get();
        //collection for get or all but new PostResource this for one post only
        // $post=Post::where('slug',"test")->first();
        //new postcolection($posts)=> we must use post collection like php artisan make:resource PostCollection when we need to add a key in addtion to the post colection like post counts and this take collection only not single post
        //->response()->getData(true) to show the pagination
        $data = [
            // 'post'=>new PostResource($post),
            // 'posts' => PostResource::collection($posts),
            'posts' => (new PostCollection($posts))->response()->getData(true),

            'latest_posts' => new PostCollection($latest_posts),
            'categories_with_posts' => new CategoryCollection($categories_with_posts),
            'most_three_viewd_posts' => new PostCollection($mostThreeViewdPosts),
            'oldestNews' => new PostCollection($oldestNews),
            'gretest_post_comments' => new PostCollection($gretestPostComments),

        ];
        return apiResponse(200, 'sucess', $data);
    }
    public function showPost($slug)
    {
        $post = Post::with([
            'images',
            'user',
            'category',
            'comments'
        ])->where('slug', $slug)->first();
        if (!$post) {

            return apiResponse('404', 'post not founded', null);

        }
        return apiResponse('200', 'post found', new PostResource($post));

    }
    public function getSettings()
    {
        $settings = Setting::first();
        $related_sites = RelativeSite::all();
        $data = [
            'settings' => $settings,
            'related_sites' => $related_sites
        ];
        return apiResponse('200', 'post found', $data);

    }
    public function getCategories()
    {
        $categories = Category::where('status', 1)->get();

        return apiResponse('200', 'categogies found', new CategoryCollection($categories));

    }
    public function getCategoryPosts($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts;

        return apiResponse('200', 'categogies found', new PostCollection($posts));

    }

    public function storeContacts(ContactRequest $request)
    {

        $request->merge([
            'ip_address' => $request->ip()
        ]);
        $contact = Contact::create($request->all()); //$request->all() validated data and if there is a key not in validtion will be appear with token
        if (!$contact) {
            return apiResponse(400, 'contact not saved');
        }
        $rolesIds = [];
        foreach (Autherization::all() as $authrization) {
            foreach ($authrization->permessions as $permession) {
                if ($permession == "contacts") {
                    $rolesIds[] = $authrization->id;
                }
            }
        }

        $admins = Admin::whereIn('autherization_id', $rolesIds)->where('status', 1)->get();
        Notification::send($admins, new NewContactNotify($contact));

        return apiResponse(201, 'contact created');
    }

}
