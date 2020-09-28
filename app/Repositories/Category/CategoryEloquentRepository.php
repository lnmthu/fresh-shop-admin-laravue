<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Laravue\Models\Category;


class CategoryEloquentRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }
    /**
     * storeCategory
     * @param $request
     * @return mixed
     */
    public function storeCategory(Request $request)
    {
        $params = $request->all();
        $category = $this->store([
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
     * updateCategory
     * @param $request
     * @param $id
     * @return bool|mixed
     */
    public function updateCategory(Request $request, $id)
    {
        $params = $request->all();
        $category = $this->update($id, [
            'name' => $params['name'],
            'parent_id' => $params['parent_id'],
            'sort' => $params['sort'],
            'status' => $params['status'],
            'description' => $params['description'],
        ]);
        $image = $request->get('image_uri');
        $category = $this->findById($id);
        $oldImage = $category->getFirstMediaUrl('images');
        if ($oldImage && $oldImage !== $image) {
            unlink(public_path($oldImage));
            $category->clearMediaCollection('images');
        }
        if ($image && $image !== $oldImage) {
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/') . $name);
            $category->addMedia(public_path('images/') . $name)->toMediaCollection('images');
        }
        return $category;
    }
    /**
     * deleteCategory
     * @param $id;
     * @return bool
     */
    public function deleteCategory($id)
    {
        $category = $this->findById($id);
        $oldImage = $category->getFirstMediaUrl('images');
        if ($oldImage) {
            $category->clearMediaCollection('images');
            if(file_exists(public_path($oldImage)))
                unlink(public_path($oldImage));
        }
        $category->delete();
        return true;
    }
}
