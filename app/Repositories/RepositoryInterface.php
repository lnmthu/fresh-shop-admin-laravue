<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();

    public function getAllWithTrash();

    public function getAllDeleted();
    
    public function getAllPaginate(array $params);

    public function findById(int $id);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function getAllTrash(array $params);

    public function restore($id);

    public function generateUniqueId();

}
