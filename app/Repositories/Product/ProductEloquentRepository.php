<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Laravue\Models\Product;
use Illuminate\Support\Arr;
use PhpParser\Node\Stmt\TryCatch;
use Exception;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileUnacceptableForCollection;

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
            try {
                $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($image)->save(public_path('images/') . $name);
                $product->addMedia(public_path('images/') . $name)->toMediaCollection('images');
            } catch (Exception $e) {
                throw new FileUnacceptableForCollection($e->getMessage());
            }
        }
        return $product;
    }

    public function update(array $data, $id)
    {
        $product = $this->findById($id);
        if ($product) {
            $image = $data['image_uri'];
            $oldImage = $product->getFirstMedia('images');
            if ($oldImage && $oldImage->getFullUrl('thumb') === $image) {
                $product->update($data);
                return $product;
            }
            if ($oldImage) {
                if (file_exists(public_path($oldImage->getUrl())))
                    unlink(public_path($oldImage->getUrl()));
                $product->clearMediaCollection('images');
            }
            if ($image) {
                try {
                    $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                    \Image::make($image)->save(public_path('images/') . $name);
                    $product->addMedia(public_path('images/') . $name)->toMediaCollection('images');
                } catch (Exception $e) {
                    throw new FileUnacceptableForCollection($e->getMessage());
                }
            }
            $product->update($data);
            return $product;
        }
    }
    public function delete($id)
    {
        $product = $this->model->withTrashed()->where('unique_id', $id)->firstOrFail();;
        if ($product->trashed()) {
            if ($product->orders()->count() > 0)
                return false;
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
    public function getProductWithCategoryUnique($category_unique_id, array $params)
    {
        $limit = Arr::get($params, 'limit', static::ITEM_PER_PAGE);
        return $this->model->where('category_unique_id', $category_unique_id)->paginate($limit);
    }
}
