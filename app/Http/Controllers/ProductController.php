<?php

namespace App\Http\Controllers;

use App\Laravue\Models\Product;
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
        return ProductResource::collection($this->productEloquentRepository->getProduct($request));
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
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @param  \App\Laravue\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product=$this->productEloquentRepository->updateProduct($request,$product);
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
    public function destroy(Product $product)
    {
        $result=$this->productEloquentRepository->deleteProduct($product);
        if(!$result)
            return response()->json(['error' => 'Product not found'], 404);
        return response()->json(null, 204);
    }
}
