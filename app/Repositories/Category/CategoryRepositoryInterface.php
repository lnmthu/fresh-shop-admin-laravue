<?php
namespace App\Repositories\Category;

use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    /**
    * storeCategory
    * @param $request
    * @return mixed
    */
   public function storeCategory(Request $request);
    /**
     * updateCategory
     * @param $request
     * @param $id
     * @return bool|mixed
     */
    public function updateCategory(Request $request,$id);
    /**
     * Delete
     * @param $id;
     * @return bool
     */
    public function deleteCategory($id);
}