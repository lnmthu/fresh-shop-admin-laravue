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
        $products = $this->productEloquentRepository->getAllPaginate($params);
        return ProductResource::collection($products);
    }
    /**
     * Display a listing of the only trash resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getListOnlyTrash(Request $request)
    {
        $params = $request->all();
        $products = $this->productEloquentRepository->getAllTrash($params);
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
        $data = $request->all();
        $data['unique_id'] = $this->productEloquentRepository->generateUniqueId();
        $product = $this->productEloquentRepository->create($data);
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  $unique_id
     * @return \Illuminate\Http\Response
     */
    public function show($unique_id)
    {
        $product = $this->productEloquentRepository->findById($unique_id);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @param  $unique_id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $unique_id)
    {
        $data = $request->all();
        $product = $this->productEloquentRepository->update($data, $unique_id);
        if (!$product) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $unique_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($unique_id)
    {
        $result = $this->productEloquentRepository->delete($unique_id);
        if (!$result)
            return response()->json(['error' => 'Product not found'], 404);
        return response()->json(null, 204);
    }
    /**
     * Restore the specified resource from storage.
     *
     * @param   $unique_id
     * @return \Illuminate\Http\Response
     */
    public function restore($unique_id)
    {
        $product = $this->productEloquentRepository->restore($unique_id);
        if (!$product)
            return response()->json(['error' => 'Product not found'], 404);
        return new ProductResource($product);
    }
}
