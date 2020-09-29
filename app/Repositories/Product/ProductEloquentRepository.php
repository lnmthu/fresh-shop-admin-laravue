<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use App\Laravue\Models\Product;

class ProductEloquentRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }
    /**
     * storeCategory
     * @param $request
     * @return mixed
     */
    public function storeProduct(Request $request)
    {
        $params = $request->all();
        $product = $this->store([
            'name' => $params['name'],
            'sku' => $params['sku'],
            'description' => $params['description'],
            'price' => $params['price'],
            'qty' => $params['qty'],
            'sort' => $params['sort'],
            'category_id' => $params['category_id'],
        ]);
        $image = $request->get('image_uri');
        if ($image) {
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/') . $name);
            $product->addMedia(public_path('images/') . $name)->toMediaCollection('images');
        }
        return $product;
    }
    /**
     * Update
     * @param $request
     * @param object $category
     * @return bool|mixed
     */
    public function updateProduct(Request $request, $id)
    {
        $params = $request->all();
        $product = $this->update([
            'name' => $params['name'],
            'sku' => $params['sku'],
            'description' => $params['description'],
            'price' => $params['price'],
            'qty' => $params['qty'],
            'sort' => $params['sort'],
            'category_id' => $params['category_id'],
        ], $id);
        $image = $request->get('image_uri');
        $product = $this->findById($id);
        $oldImage = $product->getFirstMediaUrl('images');
        if ($oldImage && $oldImage !== $image) {
            unlink(public_path($oldImage));
            $product->clearMediaCollection('images');
        }
        if ($image && $image !== $oldImage) {
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/') . $name);
            $product->addMedia(public_path('images/') . $name)->toMediaCollection('images');
        }
        return $product;
    }
    /**
     * Delete
     * @param object $model;
     * @return bool
     */
    public function deleteProduct($id)
    {
        $product = $this->findById($id);
        $oldImage = $product->getFirstMediaUrl('images');
        if ($oldImage) {
            $product->clearMediaCollection('images');
            if (file_exists(public_path($oldImage)))
                unlink(public_path($oldImage));
        }
        $product->delete();
        return true;
    }
}
