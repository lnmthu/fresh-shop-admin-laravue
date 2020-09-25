<?php

namespace App\Repositories\BlogCategory;

use App\Repositories\RepositoryInterface;

interface BlogCategoryRepositoryInterface extends RepositoryInterface
{
    public function createBlogCategory(array $newData);
    
    public function getAllPaginate(array $params);
}
