<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class Statistcs extends Component
{
    public function render()
    {
        $activeCategoriesCount=Category::where('status',1)->count();
        $activePostsCount=Post::where('status',1)->count();
        $coummentsCount=Comment::count();
        $activeUsersCount=User::where('status',1)->count();

        return view('livewire.admin.statistcs',compact('activeCategoriesCount','activePostsCount','coummentsCount','activeUsersCount'));
    }
}
