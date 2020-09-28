<?php
namespace App\Repositories\Product;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    /**
     * storeCategory
     * @param $request
     * @return mixed
     */
    public function storeProduct(Request $request);
    /**
     * updateCategory
     * @param $request
     * @param $id
     * @return bool|mixed
     */
    public function updateProduct(Request $request,$id);
        /**
     * deleteProduct
     * @param $id;
     * @return bool
     */
    public function deleteProduct($id);
}