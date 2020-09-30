<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Laravue\Models\Product;

class ProductEloquentRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function create(array $data)
    {
        $product = $this->model->create($data);
        $image = $data['image_uri'];
        if ($image) {
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/') . $name);
            $product->addMedia(public_path('images/') . $name)->toMediaCollection('images');
        }
        return $product;
    }

    public function update(array $data, $id)
    {
        $product = $this->findById($id);
        $image = $data['image_uri'];
        $oldImage = $product->getFirstMedia('images');
        if ($oldImage && $oldImage->getUrl('thumb') === $image){
            $product->update($data);
            return $product;
        }
        if ($oldImage) {
            unlink(public_path($oldImage->getUrl('thumb')));
            $product->clearMediaCollection('images');
        }
        if ($image) {
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/') . $name);
            $product->addMedia(public_path('images/') . $name)->toMediaCollection('images');
        }
        $product->update($data);
        return $product;
    }
    public function delete($id)
    {
        $product = $this->model->withTrashed()->where('unique_id', $id)->firstOrFail();;
        if ($product->trashed()) {
            $oldImage = $product->getFirstMediaUrl('images');
            if ($oldImage) {
                $product->clearMediaCollection('images');
                if (file_exists(public_path($oldImage)))
                    unlink(public_path($oldImage));
            }
            $product->forceDelete();
            return $product;
        }
        $product->delete();
        return $product;
    }
}
