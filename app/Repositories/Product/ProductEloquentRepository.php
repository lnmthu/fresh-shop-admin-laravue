<?php

namespace App\Repositories\Product;

use App\Repositories\EloquentRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductEloquentRepository extends EloquentRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return \App\Laravue\Models\Product::class;
    }
    /**
     * getCategory
     * @param $request
     * @return mixed
     */
    public function getProduct(Request $request){
        return $this->getPaginate($request->limit ?? 10);
    }
    /**
     * storeCategory
     * @param $request
     * @return mixed
     */
    public function storeProduct(Request $request)
    {
        $params = $request->all();
        $product = $this->create([
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
    public function updateProduct(Request $request, object $product)
    {
        $params = $request->all();
        $product = $this->update($product, [
            'name' => $params['name'],
            'sku' => $params['sku'],
            'description' => $params['description'],
            'price' => $params['price'],
            'qty' => $params['qty'],
            'sort' => $params['sort'],
            'category_id' => $params['category_id'],
        ]);
        $oldImage=$product->getFirstMedia('images')->getUrl();
        if($oldImage){
            unlink(public_path($oldImage));
            $product->clearMediaCollection('images');
        }
        $image = $request->get('image_uri');
        if ($image) {
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
    public function deleteProduct(object $product){
        if($product){
            $oldImage=$product->getFirstMedia('images')->getUrl();
            if($oldImage){
                unlink(public_path($oldImage));
                $product->clearMediaCollection('images');
            }
            $this->delete($product);
            return true;
        }
        return false;
    }
}
