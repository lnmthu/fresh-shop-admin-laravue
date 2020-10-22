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

    public function getAllWithTrash()
    {
        return $this->model->withTrashed()->get();
    }

    public function getAllDeleted()
    {
        return $this->model->onlyTrashed()->get();
    }

    public function getAllPaginate(array $params)
    {
        $limit = Arr::get($params, 'limit', static::ITEM_PER_PAGE);
        return $this->model->paginate($limit);
    }

    public function findById($id)
    {
        return $this->model->where('unique_id', $id)->firstOrFail();
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
        $result = $this->model->withTrashed()->where('unique_id', $id)->firstOrFail();

        if ($result->trashed()) {

            $result->forceDelete();

            return $result;
        } else {

            $result->delete();

            return $result;
        }

        return $result;
    }

    public function getAllTrash(array $params)
    {
        $limit = Arr::get($params, 'limit', static::ITEM_PER_PAGE);
        // return $this->model->paginate($limit);
        $result = $this->model->onlyTrashed()->paginate($limit);

        return $result;
    }

    public function restore($id)
    {
        $result =  $this->model->withTrashed()->where('unique_id', $id)->firstOrFail();

        $result->restore();

        return $result;
    }

    public function generateUniqueId()
    {
        do {
            $unique_id = mt_rand(10000000, 99999999);
        } while ($this->model->where('unique_id', $unique_id)->exists());
        return $unique_id;
    }

}