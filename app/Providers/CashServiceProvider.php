<?php

namespace App\Providers;

use App\Models\Post;
use Cache;
use Illuminate\Support\ServiceProvider;

class CashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // cache is faster than database to retrive the data
        if (!Cache::has('read_more_posts')) {
            $read_more_posts = Post::select('id', 'title','slug')->latest()->limit(10)->get();
            Cache::remember("read_more_posts", 3600, function () use ($read_more_posts) {
                return $read_more_posts;
            });
        }

        if (!Cache::has('latest_posts')) {
            //we add id for selection to get any relation with the post
            $latest_posts=Post::select('id','title','slug')->latest()->limit(5)->get();
            Cache::remember("latest_posts", 3600, function () use ($latest_posts) {
                return $latest_posts;
            });
        }
        if (!Cache::has('gretestPostComments')) {
            //we add id for selection to get any relation with the post
            $gretestPostComments = Post::withCount('comments')->orderBy('comments_count', 'desc')->take(5)->get();
            Cache::remember("gretestPostComments", 3600, function () use ($gretestPostComments) {
                return $gretestPostComments;
            });
        }
        $latest_posts = Cache::get('latest_posts');
        $gretestPostComments = Cache::get('gretestPostComments');

        $read_more_posts = Cache::get('read_more_posts');
        view()->share(['read_more_posts' => $read_more_posts,'latest_posts'=>$latest_posts,
        'gretestPostComments'=>$gretestPostComments]);
    }
}
