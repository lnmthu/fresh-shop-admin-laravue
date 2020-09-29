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

    const ITEM_PER_PAGE = 15;

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
            $image = $data['image'];
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            // $path = public_path('images/');
            Image::make($data['image'])->save($name);
            $blogItem
                ->addMedia($name)
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

        if ($blogItem) {
            $oldImage =  $blogItem->getFirstMedia()->getPath();

            if (isset($data['image'])) {
                $image = $data['image'];
                $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                Image::make($data['image'])->resize(150, 120)->save($name);
                unlink($oldImage);
                $blogItem->clearMediaCollection();
                $blogItem
                    ->addMedia($name)
                    ->toMediaCollection();
            }

            $blogItem->update($data);

            return $blogItem;
        }

        return false;
    }
}
