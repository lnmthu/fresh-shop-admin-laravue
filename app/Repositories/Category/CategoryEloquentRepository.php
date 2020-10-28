<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Laravue\Models\Category;


class CategoryEloquentRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function create(array $data)
    {
        $category = $this->model->create($data);
        $image = $data['image_uri'];
        if ($image) {
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/') . $name);
            $category->addMedia(public_path('images/') . $name)->toMediaCollection('images');
        }
        return $category;
    }

    public function update(array $data, $id)
    {
        $category = $this->findById($id);
        if ($category) {
            $image = $data['image_uri'];
            $oldImage = $category->getFirstMedia('images');
            if ($oldImage && $oldImage->getFullUrl('thumb') === $image) {
                $category->update($data);
                return $category;
            }
            if ($oldImage) {
                unlink(public_path($oldImage->getFullUrl('thumb')));
                $category->clearMediaCollection('images');
            }
            if ($image) {
                $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($image)->save(public_path('images/') . $name);
                $category->addMedia(public_path('images/') . $name)->toMediaCollection('images');
            }
            $category->update($data);
            return $category;
        }
    }
    public function delete($id)
    {
        $category = $this->model->withTrashed()->where('unique_id', $id)->firstOrFail();;
        if ($category->trashed()) {
            $oldImage = $category->getFirstMediaUrl('images');
            if ($oldImage) {
                $category->clearMediaCollection('images');
                if (file_exists(public_path($oldImage)))
                    unlink(public_path($oldImage));
            }
            $category->forceDelete();
            return $category;
        }
        $category->delete();
        return $category;
    }
}
