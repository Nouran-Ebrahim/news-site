<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class LatestPostsComments extends Component
{
    public function render()
    {
        $latestPosts = Post::with([
            'category'
        ])->active()->withCount('comments')->latest()->take(6)->get();
        $latestComments = Comment::with([
            'post',
            'user'
        ])->latest()->take(6)->get();

        return view('livewire.admin.latest-posts-comments', compact('latestPosts', 'latestComments'));
    }
}
