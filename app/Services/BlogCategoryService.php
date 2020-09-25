<?php


namespace App\Services;

use App\Repositories\BlogCategory\BlogCategoryRepositoryInterface;

class BlogCategoryService
{
    private $blogCategoryRepository;

    public function __construct(BlogCategoryRepositoryInterface $blogCategoryRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    public function createBlogCategory(array $newData)
    {
        $newData = [
            'title' => $newData['title'],
            'description' => $newData['description'],
            'sort' => $newData['sort'],
        ];

        return $this->blogCategoryRepository->createBlogCategory($newData);
    }

    // public function updateBlogCategory(array $data, $id)
    // {
    //     $data = [
    //         'title' => $data['title'],
    //         'description' => $data['description'],
    //         'sort' => $data['sort'],
    //     ];

    //     return $this->blogCategoryRepository->updateBlogCategory($data, $id);
    // }
}
