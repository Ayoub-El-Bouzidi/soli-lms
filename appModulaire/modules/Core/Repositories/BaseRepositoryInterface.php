<?php

namespace Modules\Core\Repositories;


interface BaseRepositoryInterface
{
    public function getAll();
    public function paginate(int $perPage = 10);
    public function find(int $id);
    public function findOrFail(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
