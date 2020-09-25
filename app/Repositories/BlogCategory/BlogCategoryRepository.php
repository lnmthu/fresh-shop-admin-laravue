<?php

namespace App\Repositories\BlogCategory;

use App\Laravue\Models\BlogCategory;
use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;

class BlogCategoryRepository extends BaseRepository implements BlogCategoryRepositoryInterface
{
    protected $model;

    const ITEM_PER_PAGE = 15;

    public function __construct(BlogCategory $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }

    public function createBlogCategory(array $newData)
    {
        try {
            $newBlogCategory = new $this->model;
            $newBlogCategory->fill($newData);
            $newBlogCategory->save();

            return $newBlogCategory;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllPaginate(array $params)
    {
        $limit = Arr::get($params, 'limit', static::ITEM_PER_PAGE);
        return $this->model->orderBy('sort', 'ASC')->paginate($limit);
    }

    public function delete($id)
    {
        $result = $this->model->withTrashed()->findOrFail($id);

        if($result->blogItems->count() >0){

            return false;
        }

        if ($result->trashed()) {

            $result->forceDelete();

            return $result;
        } else {

            $result->delete();

            return $result;
        }

        return $result;
    }
    // public function updateBlogCategory(array $data, $id)
    // {
    //     try {
    //         $result =  $this->blogCategory->findOrFail($id);

    //         if($result){
    //             $result->update($data);

    //             return $result;
    //         }
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
}
