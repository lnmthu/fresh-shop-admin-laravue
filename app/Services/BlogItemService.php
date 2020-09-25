<?php


namespace App\Services;

use App\Repositories\BlogItem\BlogItemRepositoryInterface;

class BlogItemService
{
    private $blogItemRepository;

    public function __construct(BlogItemRepositoryInterface $blogItemRepository) {
        $this->blogItemRepository = $blogItemRepository;
    }

    public function createBlogItem(array $newData)
    {
        $newData = [
            'title' => $newData['title'],
            'description' => $newData['description'],
            'body' => $newData['body'],
            'user_id' => $newData['user_id'],
            'blog_category_id' => $newData['blog_category_id'],
            'sort' => $newData['sort'],
            'status' => 1,
        ];

        return $this->blogItemRepository->createBlogItem($newData);
    }

}
