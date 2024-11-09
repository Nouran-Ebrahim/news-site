<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;
use Notification;

class PostController extends Controller
{
    public function show($slug)
    {
        // if need a post with 3 comments only
        $mainPost = Post::active()->with([
            'comments' => function ($q) {
                $q->latest()->limit(3);
            }
        ])->where('slug', $slug)->first();
        // we should check first if we did not use finorfail as it is automaticly gose to 404 if the object not found
        if (!$mainPost) {
            abort(404);

        }
        $mainPost->increment('num_of_views');
        $category = $mainPost->category;
        $posts = Post::active()->where('category_id', $category->id)->where('id', '!=', $mainPost->id)->limit(5)->get();

        return view('frontend.show', compact('mainPost', 'posts'));
    }
    public function getAllcomments($slug)
    {
        // return $slug;
        $post = Post::active()->where('slug', $slug)->first();
        $comments = $post->comments()->with('user')->get();
        return response()->json($comments);
    }
    public function storeComments(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:200',
            'user_id' => 'required|exists:users,id'
        ]);
        $comment = Comment::create([
            'user_id' => $request->user_id,//the user who make the comment (auth user)
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'ip_address' => $request->ip(),
        ]);
        $post = Post::findOrFail($request->post_id);
        $user = $post->user; // this the user who make the post that will be notify that some one(user_id) commnet on his post
        // if i need to send notfications to all users
        // $users = User::where('id',!= ,"auth()->user()->id")->get();
        //Notification::send($users,new NewCommentNotify($comment, $post))
        if (auth()->user()->id != $request->user_id) {
            $user->notify(new NewCommentNotify($comment, $post));

        }
        // we can push notifiction real time useing event or notifiaction class
        if (!$comment) {
            return response()->json([
                'error' => 'comment not created',
                'status' => 403

            ]);
        }
        // to load the relation with the collection
        $comment->load('user');
        return response()->json([
            'msg' => 'comment created successfully',
            'comment' => $comment,
            'status' => 201
        ]);


    }

}
