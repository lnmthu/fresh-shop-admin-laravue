<?php
namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getProductWithCategoryUnique($category_unique_id, array $params);
}