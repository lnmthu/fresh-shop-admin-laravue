<?php

namespace App\Repositories\Order;

use App\Laravue\Models\Order;
use App\Laravue\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Str;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes)
    {
        $attributes['code'] = '#GOSHOPP-' . Str::random(5) . sha1(time());
        $attributes['unique_id'] = $this->generateUniqueId();
        $products = [4];
        $products = Product::whereIn('id', $products)->get();

        $order = $this->model->create($attributes);

        foreach ($products as $item) {
            $order->products()->attach([
                $item->id => [
                    'qty' => 1,
                    'price' => $item->price,
                    'product_name' => $item->name,
                    'product_sku' => $item->sku,
                    'product_description' => $item->description,
                ]
            ]);
        }

        return $order;
    }
}
