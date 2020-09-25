<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Laravue\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryEloquentRepository;
    public function __construct(CategoryRepositoryInterface $categoryEloquentRepository)
    {
        $this->categoryEloquentRepository = $categoryEloquentRepository;
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return CategoryResource::collection($this->categoryEloquentRepository->getCategory($request));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryEloquentRepository->storeCategory($request);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @param  \App\Laravue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category=$this->categoryEloquentRepository->updateCategory($request,$category);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $result=$this->categoryEloquentRepository->deleteCategory($category);
        if(!$result)
            return response()->json(['error' => 'Category not found'], 404);
        return response()->json(null, 204);
    }
}
