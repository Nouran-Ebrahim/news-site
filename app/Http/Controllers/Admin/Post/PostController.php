<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use App\Utilts\ImageManger;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Str;
use Cache;
use Yajra\DataTables\Exceptions\Exception;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('can:posts');
        // if we have create_posts permession and we need to aply this for create and store only so make thsi
        // $this->middleware('can:create_posts')->only(['cearte','store']);
    }
    public function index()
    {
        // return request();//this equal to Request $request
        $order_by = request()->orderby ?? 'desc'; //insread of adding the request with default like sort by

        $posts = Post::with(['user', 'category'])
            ->when(request()->keyword ?? null, function ($q) {
                $q->where('title', 'like', '%' . request()->keyword . '%')
                    ->orwhere('desc', 'like', '%' . request()->keyword . '%');
            })
            ->when(!is_null(request()->status), function ($q) {
                $q->where('status', request()->status);
            })
            ->orderBy(request('sortby', 'id'), $order_by)
            ->paginate(request('limit', 5));

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->select('id', 'name')->get();
        $users = User::where('status', 1)->select('id', 'name')->get();


        return view('admin.posts.create', compact('categories', 'users'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            DB::beginTransaction();
            // like videos we can make the admin create post and add column admin_id as nullable and also user_id as nullable and create post form admin with gaurd admin and any place there is $post->user->name we must make this $post->user->name??$post->admin->name as realtion admin
            $post = Post::create($request->except('images'));
            if ($request->hasFile('images')) {

                foreach ($request->images as $image) {

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

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load([
            'comments' => function ($query) {
                $query->latest()->limit(3); // Adjust this number if needed
            }
        ]);

        return view('admin.posts.show', compact('post'));
    }
    public function getAllcomments(Post $post, Request $request)
    {
        // Get the current page number from the request, default to 1
        $page = $request->input('page', 1);
        $perPage = 3; // Number of comments per page
        $offset = ($page - 1) * $perPage; // Calculate the offset for pagination

        // Fetch comments with pagination
        $comments = $post->comments()->with('user')
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        return response()->json($comments);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //in edit if we make that admin can make post so admin can edit only posts reated form the admin and any post created form user can not edit it
        $users = User::all();
        return view('admin.posts.edit', compact('post', 'users'));

    }

    /**
     * Update the specified resource in storage.
     */
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
    public function update(PostRequest $request, Post $post)
    {
        // return $request;
        try {
            DB::beginTransaction();

            $post->update($request->except('images', '_token'));

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

            return redirect()->route('admin.posts.index');
        } catch (\Exception $exception) {
            DB::rollback();
            report($exception);
            //to show errors in the list
            return redirect()->back()->withErrors(['errors' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        foreach ($post->images as $image) {
            $filePath = public_path('uploads' . DIRECTORY_SEPARATOR . 'posts' . DIRECTORY_SEPARATOR . $image->path);
            ImageManger::deleteImage($filePath);

        }
        $post->delete();
        Session::flash('success', 'Post deleted');
        return redirect()->route('admin.posts.index');
    }
    public function toggleStatus(Post $post)
    {
        $post->status = !$post->status;
        $post->save();
        Session::flash('success', 'Status Updated');
        return redirect()->back();
    }
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        Session::flash('success', 'Comment Deleted');
        return redirect()->back();
    }
}
