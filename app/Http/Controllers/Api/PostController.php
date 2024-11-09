<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Notifications\NewCommentNotify;
use App\Utilts\ImageManger;
use Cache;
use File;
use Illuminate\Http\Request;
use Log;
use Str;
use Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Exceptions\Exception;

class PostController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $posts = $user->posts()->where('status', 1)->get();
        if ($posts->count() > 0) {
            return apiResponse(200, 'this user posts', new PostCollection($posts));
        }
        return apiResponse(404, 'this user posts not found');
    }
    public function store(PostRequest $request)
    {
        try {
            DB::beginTransaction();

            $post = auth()->user()->posts()->create($request->except('images'));
            if ($request->hasFile('images')) {

                foreach ($request->images as $image) {
                    // for none static method
                    // $imageManger = new ImageManger;
                    // $fileName = $imageManger->uploadImage($image, 'uploads/posts', 'uploads');

                    //for static function
                    $fileName = ImageManger::uploadImage($image, 'uploads/posts', 'uploads');
                    $post->images()->create(['path' => $fileName]);
                }

            }
            DB::commit();
            Cache::forget('read_more_posts'); // to rest more postests as  i add new one and in delete the post we must forget the key to delete it from the cash and get new cash
            Cache::forget('latest_posts'); // to rest more postests as  i add new one and in delete the post we must forget the key to delete it from the cash and get new cash

            return apiResponse(200, 'post created successfully', new PostResource($post));
        } catch (\Exception $exception) {
            DB::rollback();
            report($exception);
            //to show errors in the list
            Log::error('error from create post : ' . $exception->getMessage());
            return apiResponse(500, 'inr=ternal server error');
        }
    }
    public function destroy($id)
    {

        $post = Post::where('id', $id)->where('user_id', auth()->user()->id)->first();

        if (!$post) {
            return apiResponse(404, 'this  post not found');
        }
        if ($post->images->count() > 0) {
            foreach ($post->images as $image) {
                $filePath = public_path('uploads' . DIRECTORY_SEPARATOR . 'posts' . DIRECTORY_SEPARATOR . $image->path);
                ImageManger::deleteImage($filePath);
            }
        }
        $post->delete();
        return apiResponse(200, 'post deleted');

    }
    public function storeComment(Request $request)
    {
        //sometimes used as when we send user id in the request so excute the validation else as the user id not in the request (no key with user id) so the validation not excuted
        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'comment' => 'required|string|max:200',
            'post_id' => 'required|exists:posts,id'
        ]);
        $user = auth()->user();
        $post = Post::findOrFail($request->post_id);
        $comment = $post->comments()->create([
            'user_id' => $user->id,//the user who make the comment (auth user)
            'comment' => $request->comment,
            'ip_address' => $request->ip()
        ]);

        $userPost = $post->user; // this the user who make the post that will be notify that some one(user_id) commnet on his post
        // if i need to send notfications to all users
        // $users = User::where('id',!= ,"auth()->user()->id")->get();
        //Notification::send($users,new NewCommentNotify($comment, $post))
        if ($user->id != $userPost->id) {
            $userPost->notify(new NewCommentNotify($comment, $post));

        }
        // we can push notifiction real time useing event or notifiaction class
        if (!$comment) {

            return apiResponse(403, 'comment not created');

        }
        // to load the relation with the collection
        // $comment->load('user');

        return apiResponse(201, 'comment created successfully', $comment);

    }
}
