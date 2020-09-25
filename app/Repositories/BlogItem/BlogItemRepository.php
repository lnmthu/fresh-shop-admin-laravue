<?php


namespace App\Repositories\BlogItem;

use App\Laravue\Models\BlogItem;
use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;

class BlogItemRepository extends BaseRepository implements BlogItemRepositoryInterface
{
    protected $model;

    const ITEM_PER_PAGE = 15;

    public function __construct(BlogItem $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }

    public function createBlogItem(array $newData)
    {
        try {
            $newBlogItem = new BlogItem();
            $newBlogItem->fill($newData);
            $newBlogItem->save();

            return $newBlogItem;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllPaginate(array $params)
    {
        $limit = Arr::get($params, 'limit', static::ITEM_PER_PAGE);
        return $this->model->orderBy('sort', 'ASC')->paginate($limit);
    }

    public function update(array $data, $id)
    {
        $result = $this->model->findOrFail($id);

        if ($result) {

            if (isset($data['image'])) {
                $image = $data['image'];
                $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                Image::make($data['image'])->resize(150, 120)->save($name);
                $result
                    ->addMedia($name)
                    ->toMediaCollection();
            }

            $result->update($data);

            return $result;
        }

        return false;
    }
}
