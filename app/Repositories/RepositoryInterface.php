<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get
     * @return mixed
     */
    public function get();
    /**
     * Get all
     * @return mixed
     */
    public function getAll();
    /**
     * Get paginate
     * @return mixed
     */
    public function getPaginate($limit);
    /**
     * Get one
     * @return mixed
     */
    public function first();
    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function findOrFail($id);

    /**
     * Condition
     * @param $index, $value
     * @return mixed
     */
    public function where($index, $value);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @param object $model
     * @param array $attributes
     * @return bool|mixed
     */
    public function update(object $model, array $attributes);

    /**
     * Delete
     * @param object $model;
     * @return bool
     */
    public function delete(object $model);
}
