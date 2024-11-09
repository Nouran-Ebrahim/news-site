<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralSearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->option == "post") {
            $posts = Post::where('title', 'like', '%' . $request->keyword . '%')->paginate(5);
            return view('admin.posts.index', compact('posts'));
        } elseif ($request->option == "user") {
            $users = User::where('name', 'like', '%' . $request->keyword . '%')->paginate(5);
            return view('admin.users.index', compact('users'));

        } elseif ($request->option == "category") {
            $categories = Category::where('name', 'like', '%' . $request->keyword . '%')->paginate(5);
            return view('admin.categories.index', compact('categories'));

        } elseif ($request->option == "contact") {
            $contacts = Contact::where('name', 'like', '%' . $request->keyword . '%')->paginate(5);
            return view('admin.contacts.index', compact('contacts'));

        } else {
            return redirect()->back();
        }
    }
}
