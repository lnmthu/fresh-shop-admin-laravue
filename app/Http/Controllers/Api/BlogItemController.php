<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogItem\StoreBlogItemRequest;
use App\Http\Requests\BlogItem\UpdateBlogItemRequest;
use App\Http\Resources\BlogItemResource;
use App\Laravue\Models\BlogItem;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BlogItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogItems = BlogItem::orderBy('sort', 'ASC')->paginate(15);

        return BlogItemResource::collection($blogItems);
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
    public function store(StoreBlogItemRequest $request)
    {
        $data = $request->validated();

        $blogCategory = BlogItem::create($data);

        return new BlogItemResource($blogCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogItem = BlogItem::find($id);

        return new BlogItemResource($blogItem);
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
    public function update(Request $request, BlogItem $blogItem)
    {
        if ($request->get('image')) {
            $image = $request->get('image');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('images/') . $name);
            $blogItem
                ->addMedia(public_path('images/') . $name)
                ->toMediaCollection();
        }
        // $data = $request->validated();
        // // BlogItem::create($data);
        // // $blogCategory = BlogCategory::find($id)->update($data);

        // $blogItem->update($data);

        // return new BlogItemResource($blogItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogItem = BlogItem::withTrashed()->where('id', $id)->firstOrFail();

        if ($blogItem->trashed()) {
            $blogItem->forceDelete();
        } else {
            $blogItem->delete();
        }
        // $blogItems = BlogItem::all();

        return new BlogItemResource($blogItem);
    }

    public function trashed()
    {
        $trashed = BlogItem::onlyTrashed()->get();

        return BlogItemResource::collection($trashed);
    }

    public function restore($id)
    {
        $blogItem = BlogItem::withTrashed()->where('id', $id)->firstOrFail();

        $blogItem->restore();

        return new BlogItemResource($blogItem);
    }
}
