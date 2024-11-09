<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Utilts\ImageManger;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Str;
use Yajra\DataTables\Exceptions\Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $order_by = request()->orderby ?? 'desc'; //insread of adding the request with default like sort by

        $categories = Category::
            withCount('posts')
            ->when(request()->keyword ?? null, function ($q) {
                $q->where('name', 'like', '%' . request()->keyword . '%');
            })
            ->when(!is_null(request()->status), function ($q) {
                $q->where('status', request()->status);
            })
            ->orderBy(request('sortby', 'id'), $order_by)
            ->paginate(request('limit', 5));
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'status'=>'in:0,1'
        ]);
        Category::create($request->except('_token'));
        Session::flash('success', 'Category created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'status'=>'in:0,1'
        ]);
        $category->update($request->except('_token'));
        Session::flash('success', 'Category updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Session::flash('success', 'Category deleted');
        return redirect()->route('admin.categories.index');
    }
    public function toggleStatus(Category $category)
    {
        $category->status = !$category->status;
        $category->save();
        Session::flash('success', 'Status Updated');
        return redirect()->back();
    }
}
