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
        return $this->model->findOrFail($id);
    }

    public function store(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->findById($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }
}
