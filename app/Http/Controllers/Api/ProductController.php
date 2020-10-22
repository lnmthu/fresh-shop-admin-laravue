<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productEloquentRepository;
    public function __construct(ProductRepositoryInterface $productEloquentRepository)
    {
        $this->productEloquentRepository = $productEloquentRepository;
    }
    public function index(Request $request)
    {
        $params = $request->all();
        $products = $this->productEloquentRepository->getAllPaginate($params);
        return ProductResource::collection($products);
    }
    public function getListOnlyTrash(Request $request)
    {
        $params = $request->all();
        $products = $this->productEloquentRepository->getAllTrash($params);
        return ProductResource::collection($products);
    }
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['unique_id'] = $this->productEloquentRepository->generateUniqueId();
        $product = $this->productEloquentRepository->create($data);
        return new ProductResource($product);
    }
    public function show($unique_id)
    {
        $product = $this->productEloquentRepository->findById($unique_id);
        if(!$product)
            return response()->json(['error' => 'Category not found'], 404);
        return new ProductResource($product);
    }
    public function update(ProductRequest $request, $unique_id)
    {
        $data = $request->all();
        $product = $this->productEloquentRepository->update($data, $unique_id);
        if (!$product) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return new ProductResource($product);
    }
    public function destroy($unique_id)
    {
        $result = $this->productEloquentRepository->delete($unique_id);
        if (!$result)
            return response()->json(['error' => 'Product not found'], 404);
        return response()->json(null, 204);
    }
    public function restore($unique_id)
    {
        $product = $this->productEloquentRepository->restore($unique_id);
        if (!$product)
            return response()->json(['error' => 'Product not found'], 404);
        return new ProductResource($product);
    }
    public function getAllProduct(){
        $products = $this->productEloquentRepository->getAll();
        if (!$products)
            return response()->json(['error' => 'Product not found'], 404);
        return ProductResource::collection($products);
    }
    public function getProductWithCategory($category_unique_id,Request $request){
        $params = $request->all();
        $products = $this->productEloquentRepository->getProductWithCategoryUnique($category_unique_id,$params);
        if (!$products)
            return response()->json(['error' => 'Product not found'], 404);
        return ProductResource::collection($products);
    }
}
