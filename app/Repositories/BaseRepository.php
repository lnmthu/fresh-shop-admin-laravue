<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BaseRepository implements RepositoryInterface
{
    protected $model;
    const ITEM_PER_PAGE = 15;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllPaginate(array $params)
    {
        $limit = Arr::get($params, 'limit', static::ITEM_PER_PAGE);
        return $this->model->paginate($limit);
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $result = $this->findById($id);

        if ($result) {

            $result->update($data);

            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->model->withTrashed()->findOrFail($id);

        if ($result->trashed()) {

            $result->forceDelete();

            return $result;
        } else {

            $result->delete();

            return $result;
        }

        return $result;
    }

    public function getAllTrash()
    {
        $result = $this->model->onlyTrashed()->get();

        return $result;
    }

    public function restore($id)
    {
        $result =  $this->model->withTrashed()->findOrFail($id);

        $result->restore();

        return $result;
    }
}
