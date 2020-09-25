<?php


namespace App\Repositories\BlogItem;

use App\Repositories\RepositoryInterface;

interface BlogItemRepositoryInterface extends RepositoryInterface
{
    public function createBlogItem(array $newData);

    public function getAllPaginate(array $params);
}
