<?php

namespace App\Repositories\Category;

use App\Repositories\EloquentRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryEloquentRepository extends EloquentRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return \App\Laravue\Models\Category::class;
    }
    /**
     * getCategory
     * @param $request
     * @return mixed
     */
    public function getCategory(Request $request)
    {
        $categories = $this->getPaginate($request->limit ?? 10);
        return $categories;
    }
    /**
     * storeCategory
     * @param $request
     * @return mixed
     */
    public function storeCategory(Request $request)
    {
        $params = $request->all();
        $category = $this->create([
            'name' => $params['name'],
            'parent_id' => $params['parent_id'],
            'sort' => $params['sort'],
            'status' => $params['status'],
            'description' => $params['description'],
        ]);
        $image = $request->get('image_uri');
        if ($image) {
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/') . $name);
            $category->addMedia(public_path('images/') . $name)->toMediaCollection('images');
        }
        return $category;
    }
    /**
     * Update
     * @param $request
     * @param object $category
     * @return bool|mixed
     */
    public function updateCategory(Request $request, object $category)
    {
        $params = $request->all();
        $category = $this->update($category, [
            'name' => $params['name'],
            'parent_id' => $params['parent_id'],
            'sort' => $params['sort'],
            'status' => $params['status'],
            'description' => $params['description'],
        ]);
        $oldImage=$category->getFirstMedia('images')->getUrl();
        if($oldImage){
            unlink(public_path($oldImage));
            $category->clearMediaCollection('images');
        }
        $image = $request->get('image_uri');
        if ($image) {
            $category->clearMediaCollection('images');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/') . $name);
            $category->addMedia(public_path('images/') . $name)->toMediaCollection('images');
        }
        return $category;
    }
    /**
     * Delete
     * @param object $model;
     * @return bool
     */
    public function deleteCategory(object $category){
        if($category){
            $oldImage=$category->getFirstMedia('images')->getUrl();
            if($oldImage){
                unlink(public_path($oldImage));
                $category->clearMediaCollection('images');
            }
            $this->delete($category);
            return true;
        }
        return false;
    }
}
