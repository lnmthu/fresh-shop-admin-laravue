<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategory\StoreBlogCategoryRequest;
use App\Http\Requests\BlogCategory\UpdateBlogCategoryRequest;
use App\Http\Resources\BlogCategoryResource;
use App\Laravue\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $blogCategories = BlogCategory::all();
        $blogCategories = BlogCategory::orderBy('sort', 'ASC')->paginate(15);
// dd(BlogCategory::first()->blogItems()->get());
        return BlogCategoryResource::collection($blogCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        $data = $request->validated();

        $blogCategory = BlogCategory::create($data);

        return new BlogCategoryResource($blogCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // need to change to findorfail
        // $blogCategory = BlogCategory::findOrFail($id);
        $blogCategory = BlogCategory::findOrFail($id);
        return new BlogCategoryResource($blogCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $data = $request->validated();
        // BlogCategory::create($data);
        // $blogCategory = BlogCategory::find($id)->update($data);

        $blogCategory->update($data);

        return new BlogCategoryResource($blogCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $blogCategory->delete();
         $blogCategory = BlogCategory::withTrashed()->where('id', $id)->firstOrFail();

         if ($blogCategory->trashed()) {
             $blogCategory->forceDelete();
         } else {
             $blogCategory->delete();
         }
        // $blogCategories = BlogCategory::all();

        return new BlogCategoryResource($blogCategory);
    }

    public function trashed()
    {
        $trashed = BlogCategory::onlyTrashed()->get();

        return BlogCategoryResource::collection($trashed);
    }

    public function restore($id)
    {
        $blogCategory = BlogCategory::withTrashed()->where('id', $id)->firstOrFail();

        $blogCategory->restore();

        return new BlogCategoryResource($blogCategory);
    }
}
