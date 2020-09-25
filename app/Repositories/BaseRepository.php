<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function paginate($limit = null, $columns = ('*'))
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;

        return $this->model->paginate($limit, $columns);
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
        $result = $this->model->findOrFail($id);

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
