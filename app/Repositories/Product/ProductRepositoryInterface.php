<?php
namespace App\Repositories\Product;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    /**
     * getCategory
     * @param $request
     * @return mixed
     */
    public function getProduct(Request $request);
    /**
     * storeCategory
     * @param $request
     * @return mixed
     */
    public function storeProduct(Request $request);
    /**
     * updateCategory
     * @param $request
     * @return bool|mixed
     */
    public function updateProduct(Request $request,object $category);
        /**
     * Delete
     * @param object $model;
     * @return bool
     */
    public function deleteProduct(object $product);
}