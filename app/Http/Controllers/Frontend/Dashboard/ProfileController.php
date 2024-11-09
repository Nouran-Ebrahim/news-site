<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Utilts\ImageManger;
use Cache;
use File;
use Illuminate\Http\Request;
use Log;
use Str;
use Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Exceptions\Exception;
class ProfileController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts()->active()->with('images')->latest()->get();
        // dd($posts);
        return view('frontend.dashboard.profile', compact('posts'));
    }

    public function storePost(PostRequest $request)
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

            Session::flash('success', 'Post created successfuly');

            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollback();
            report($exception);
            //to show errors in the list
            return redirect()->back()->withErrors(['errors' => $exception->getMessage()]);
        }

    }
    public function editPost($slug, Request $request)
    {
        $post = Post::where('slug', $slug)->with('images')->first();
        return view('frontend.dashboard.edit-post', compact("post"));
    }
    public function deletePostImage(Request $request)
    {
        $Image = Image::findOrFail($request->key);

        $name = $Image->path;
        $filePath = public_path('uploads' . DIRECTORY_SEPARATOR . 'posts' . DIRECTORY_SEPARATOR . $name);
        ImageManger::deleteImage($filePath);
        $Image->delete();
        return response()->json([
            'status' => 200,
            "msg" => "Image Deleted"
        ]);

    }
    public function updatePost(PostRequest $request)
    {
        try {
            DB::beginTransaction();

            $post = Post::findOrFail($request->post_id);
            $post->update($request->except('images', '_token', '_method', 'post_id'));

            if ($request->hasFile('images')) {

                if ($post->images->count() > 0) {
                    foreach ($post->images as $value) {
                        $filePath = public_path('uploads' . DIRECTORY_SEPARATOR . 'posts' . DIRECTORY_SEPARATOR . $value->path);
                        ImageManger::deleteImage($filePath);
                        $value->delete();
                    }
                    // $post->images()->delete();
                }
                foreach ($request->images as $image) {

                    $fileName = ImageManger::uploadImage($image, 'uploads/posts', 'uploads');
                    $post->images()->create(['path' => $fileName]);
                }

            }
            DB::commit();
            Cache::forget('read_more_posts'); // to rest more postests as  i add new one and in delete the post we must forget the key to delete it from the cash and get new cash
            Cache::forget('latest_posts'); // to rest more postests as  i add new one and in delete the post we must forget the key to delete it from the cash and get new cash

            Session::flash('success', 'Post Updated successfuly');

            return redirect()->route('frontend.dashboard.profile');
        } catch (\Exception $exception) {
            DB::rollback();
            report($exception);
            //to show errors in the list
            return redirect()->back()->withErrors(['errors' => $exception->getMessage()]);
        }
    }
    public function deletePost(Request $request)
    {

        $post = Post::where('slug', $request->slug)->first();

        if (!$post) {
            abort(404);
        }
        if ($post->images->count() > 0) {
            foreach ($post->images as $image) {
                $filePath = public_path('uploads' . DIRECTORY_SEPARATOR . 'posts' . DIRECTORY_SEPARATOR . $image->path);
                ImageManger::deleteImage($filePath);
            }
        }
        $post->delete();
        Session::flash('success', 'Post deleted successfuly');
        //we can make this also redirect()->back()->with('success', 'Post deleted successfuly')
        return redirect()->back();
    }
    public function getComments($id, Request $request)
    {

        $comments = Comment::with('user')->where('post_id', $id)->get();
        if ($comments->count() == 0) {
            return response()->json([
                'data' => null,
                'msg' => 'No comments found'
            ]);
        }
        return response()->json([
            'data' => $comments,
        ]);

    }

}
