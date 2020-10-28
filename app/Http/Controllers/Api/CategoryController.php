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
    public function index(Request $request)
    {
        $params = $request->all();
        $categories = $this->categoryEloquentRepository->getAllPaginate($params);
        return CategoryResource::collection($categories);
    }
    public function getListWithTrash()
    {
        $categories = $this->categoryEloquentRepository->getAllWithTrash();
        return CategoryResource::collection($categories);
    }
    public function getListOnlyTrash(Request $request)
    {
        $params = $request->all();
        $categories = $this->categoryEloquentRepository->getAllTrash($params);
        return CategoryResource::collection($categories);
    }
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $data['unique_id'] = $this->categoryEloquentRepository->generateUniqueId();
        $category = $this->categoryEloquentRepository->create($data);
        return new CategoryResource($category);
    }

    public function show($unique_id)
    {
        $category = $this->categoryEloquentRepository->findById($unique_id);
        if(!$category)
            return response()->json(['error' => 'Category not found'], 404);
        return new CategoryResource($category);
    }
    public function update(CategoryRequest $request, $unique_id)
    {
        $data = $request->all();
        $category = $this->categoryEloquentRepository->update($data, $unique_id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return new CategoryResource($category);
    }
    public function destroy($unique_id)
    {
        $result = $this->categoryEloquentRepository->delete($unique_id);
        if (!$result)
            return response()->json(['error' => 'Category not found'], 404);
        return response()->json(null, 204);
    }
    public function restore($unique_id)
    {
        $category = $this->categoryEloquentRepository->restore($unique_id);
        if (!$category)
            return response()->json(['error' => 'Category not found'], 404);
        return new CategoryResource($category);
    }

    public function getAllCategory()
    {
        $categories = $this->categoryEloquentRepository->getAll();
        return CategoryResource::collection($categories);
    }
}
