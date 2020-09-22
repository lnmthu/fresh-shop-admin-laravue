<?php

namespace App\Repository;

interface RepositoryInterface
{
    public function getAll();
    public function getAllDeleted();
    public function getAllPaginate(array $params);
    public function findById($id);
    public function store(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);
}
