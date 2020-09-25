<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogItem\StoreBlogItemRequest;
use App\Http\Requests\BlogItem\UpdateBlogItemRequest;
use App\Http\Resources\BlogItemResource;
use App\Laravue\Models\BlogItem;
use App\Repositories\BlogItem\BlogItemRepositoryInterface;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BlogItemController extends Controller
{
    private $blogItemRepository;

    private $responseHelper;

    public function __construct(BlogItemRepositoryInterface $blogItemRepository, ResponseHelper $responseHelper)
    {
        $this->blogItemRepository = $blogItemRepository;

        $this->responseHelper = $responseHelper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $blogItems = $this->blogItemRepository->getAllPaginate($params);

        return BlogItemResource::collection($blogItems);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogItemRequest $request)
    {
        $data = $request->validated();

        $blogItem = $this->blogItemRepository->create($data);

        return new BlogItemResource($blogItem);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogItem = $this->blogItemRepository->findById($id);

        return new BlogItemResource($blogItem);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogItemRequest $request, $id)
    {
        $data = $request->validated();

        $blogItem = $this->blogItemRepository->update($data, $id);

        return new BlogItemResource($blogItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogItem = $this->blogItemRepository->delete($id);

        return $this->responseHelper->successResponse(true, 'Blog Item has been trashed!', $blogItem);
    }

    public function trashed()
    {
        $trashed = $this->blogItemRepository->getAllTrash();

        return BlogItemResource::collection($trashed);
    }

    public function restore($id)
    {
        $blogItem = $this->blogItemRepository->restore($id);

        return new BlogItemResource($blogItem);
    }

    public function deactivate($id)
    {
        $blogItem = $this->blogItemRepository->update(['status' => 0], $id);

        return $this->responseHelper->successResponse(true, 'Blog Item has been deactivated!', $blogItem);
    }

    public function activate($id)
    {
        $blogItem = $this->blogItemRepository->update(['status' => 1], $id);

        return $this->responseHelper->successResponse(true, 'Blog Item has been activated!', $blogItem);
    }
}
