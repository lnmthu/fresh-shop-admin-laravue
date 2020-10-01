<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
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
        $params = $request->all();
        $categories = $this->categoryEloquentRepository->getAllPaginate($params);
        return CategoryResource::collection($categories);
    }
    /**
     * Display a listing of the with trash resource.
     * @return \Illuminate\Http\Response
     */
    public function getListWithTrash()
    {
        $categories = $this->categoryEloquentRepository->getAllWithTrash();
        return CategoryResource::collection($categories);
    }
    /**
     * Display a listing of the only trash resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getListOnlyTrash(Request $request)
    {
        $params = $request->all();
        $categories = $this->categoryEloquentRepository->getAllTrash($params);
        return CategoryResource::collection($categories);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $data['unique_id'] = $this->categoryEloquentRepository->generateUniqueId();
        $category = $this->categoryEloquentRepository->create($data);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  $unique_id
     * @return \Illuminate\Http\Response
     */
    public function show($unique_id)
    {
        $category = $this->categoryEloquentRepository->findById($unique_id);
        if(!$category)
            return response()->json(['error' => 'Category not found'], 404);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @param  $unique_id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $unique_id)
    {
        $data = $request->all();
        $category = $this->categoryEloquentRepository->update($data, $unique_id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $unique_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($unique_id)
    {
        $result = $this->categoryEloquentRepository->delete($unique_id);
        if (!$result)
            return response()->json(['error' => 'Category not found'], 404);
        return response()->json(null, 204);
    }
    /**
     * Restore the specified resource from storage.
     *
     * @param  $unique_id
     * @return \Illuminate\Http\Response
     */
    public function restore($unique_id)
    {
        $category = $this->categoryEloquentRepository->restore($unique_id);
        if (!$category)
            return response()->json(['error' => 'Category not found'], 404);
        return new CategoryResource($category);
    }
}
