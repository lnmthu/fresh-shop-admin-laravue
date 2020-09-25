<?php

namespace App\Repositories;
use App\Repositories\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }
    /**
     * Get
     * @return mixed
     */
    public function get(){
        return $this->_model->get();
    }
    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {

        return $this->_model->all();
    }
    /**
     * Get paginate
     * @return mixed
     */
    public function getPaginate($limit){
        return $this->_model->paginate($limit);
    }
    /**
     * Get one
     * @return mixed
     */
    public function first()
    {
        return $this->_model->first();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }
    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $result = $this->_model->findOrFail($id);

        return $result;
    }
    /**
     * Condition
     * @param $index, $value
     * @return mixed
     */
    public function where($index,$value){
        return $this->_model->where($index,$value);
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {

        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param object $model
     * @param array $attributes
     * @return bool|mixed
     */
    public function update(object $model, array $attributes)
    {
        if ($model) {
            $model->update($attributes);
            return $model;
        }

        return false;
    }
    
    /**
     * Delete
     * @param object $model;
     * @return bool
     */
    public function delete(object $model)
    {
        if ($model) {
            $model->delete();

            return true;
        }

        return false;
    }

}