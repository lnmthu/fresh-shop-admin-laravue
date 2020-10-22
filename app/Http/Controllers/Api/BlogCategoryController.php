<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategory\StoreBlogCategoryRequest;
use App\Http\Requests\BlogCategory\UpdateBlogCategoryRequest;
use App\Http\Resources\BlogCategoryResource;
use App\Repositories\BlogCategory\BlogCategoryRepositoryInterface;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    private $blogCategoryRepository;

    private $responseHelper;

    /**
     * BlogCategoryController constructor.
     * @param BlogCategoryRepositoryInterface $blogCategoryRepository
     * @param ResponseHelper $responseHelper
     */
    public function __construct(BlogCategoryRepositoryInterface $blogCategoryRepository, ResponseHelper $responseHelper)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;

        $this->responseHelper = $responseHelper;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $blogCategories = $this->blogCategoryRepository->getAllPaginate($params);

        return BlogCategoryResource::collection($blogCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param StoreBlogCategoryRequest $request
     * @return BlogCategoryResource
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        $data = $request->validated();

        $blogCategory = $this->blogCategoryRepository->create($data);

        return new BlogCategoryResource($blogCategory);
    }

    /**
     * @param $id
     * @return BlogCategoryResource
     */
    public function show($id)
    {
        $blogCategory = $this->blogCategoryRepository->findById($id);

        return new BlogCategoryResource($blogCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogCategoryRequest $request,  $id)
    {
        $data = $request->validated();

        $blogCategory = $this->blogCategoryRepository->update($data, $id);

        return new BlogCategoryResource($blogCategory);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $blogCategory = $this->blogCategoryRepository->delete($id);

        return $this->responseHelper->successResponse(true, 'Blog Category has been trashed!', $blogCategory);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function trashed(Request $request)
    {
        $params = $request->all();

        $trashed = $this->blogCategoryRepository->getAllTrash($params);

        return BlogCategoryResource::collection($trashed);
    }

    /**
     * @param $id
     * @return BlogCategoryResource
     */
    public function restore($id)
    {
        $blogCategory = $this->blogCategoryRepository->restore($id);

        return new BlogCategoryResource($blogCategory);
    }
    public function getAllBlogCategory()
    {
        $blogCategories = $this->blogCategoryRepository->getAll();

        return BlogCategoryResource::collection($blogCategories);
    }
}
