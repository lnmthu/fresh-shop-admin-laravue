<?php
namespace App\Repositories\Category;

use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    /**
     * getCategory
     * @param $request
     * @return mixed
     */
    public function getCategory(Request $request);
    /**
    * storeCategory
    * @param $request
    * @return mixed
    */
   public function storeCategory(Request $request);
    /**
     * updateCategory
     * @param $request
     * @return bool|mixed
     */
    public function updateCategory(Request $request,object $category);
    /**
     * Delete
     * @param object $model;
     * @return bool
     */
    public function deleteCategory(object $model);
}