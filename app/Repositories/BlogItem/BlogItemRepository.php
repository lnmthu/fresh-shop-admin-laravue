<?php


namespace App\Repositories\BlogItem;

use App\Laravue\Models\BlogItem;
use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;
use Spatie\MediaLibrary\Models\Media;

class BlogItemRepository extends BaseRepository implements BlogItemRepositoryInterface
{
    protected $model;

    const ITEM_PER_PAGE = 2;

    public function __construct(BlogItem $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }

    public function create(array $data)
    {
        $blogItem = $this->model->create($data);

        $image = isset($data['image']);

        if ($image) {
            $path = public_path('images/');
            $image = $data['image'];
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($data['image'])->save($path . $name);
            $blogItem
                ->addMedia($path . $name)
                ->toMediaCollection('blog');
        }

        return $blogItem;
    }

    public function getAllPaginate(array $params)
    {
        $limit = Arr::get($params, 'limit', static::ITEM_PER_PAGE);
        return $this->model->orderBy('sort', 'ASC')->paginate($limit);
    }

    public function update(array $data, $id)
    {
        $blogItem = $this->model->findOrFail($id);
        $newImage = $data['image'];

        if ($blogItem) {
            $path = public_path('images/');
            $oldImage = $blogItem->getFirstMedia('blog');

            if ($oldImage && $oldImage->getUrl('blog') == $newImage) {
                return $blogItem;
            } else if ($oldImage) {
                // $name = time() . '.' . explode('/', explode(':', substr($newImage, 0, strpos($newImage, ';')))[1])[1];
                // Image::make($data['image'])->resize(150, 120)->save($path . $name);
                // // unlink(public_path($oldImage->getUrl('blog')));
                $blogItem->clearMediaCollection('blog');
                //     ->addMedia($path . $name)
                //     ->toMediaCollection('blog');
            } else if ($newImage) {
                $name = time() . '.' . explode('/', explode(':', substr($newImage, 0, strpos($newImage, ';')))[1])[1];
                Image::make($data['image'])->resize(150, 120)->save($path . $name);
                $blogItem->clearMediaCollection('blog');
                $blogItem
                    ->addMedia($path . $name)
                    ->toMediaCollection('blog');
            }

            $blogItem->update($data);

            return $blogItem;
        }

        return false;
    }
    public function BlogCategoryPaginate($blog_category_id, array $params)
    {
        $limit = Arr::get($params, 'limit', static::ITEM_PER_PAGE);
        return $this->model->where('blog_category_id',$blog_category_id)->paginate($limit);
    }
}
