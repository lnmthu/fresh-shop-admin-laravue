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
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $products=$this->productEloquentRepository->getAllPaginate($params);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product=$this->productEloquentRepository->storeProduct($request);
        return new ProductResource($product);        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productEloquentRepository->findById($id);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @param  \App\Laravue\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product=$this->productEloquentRepository->updateProduct($request,$id);
        if (!$product) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result=$this->productEloquentRepository->deleteProduct($id);
        if(!$result)
            return response()->json(['error' => 'Product not found'], 404);
        return response()->json(null, 204);
    }
}
