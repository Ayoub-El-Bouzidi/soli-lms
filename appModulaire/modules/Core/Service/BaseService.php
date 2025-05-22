<?php

namespace Modules\Core\Service;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }


    public function paginate(int $perPage = 10)
    {
        return $this->model->paginate($perPage);
    }


    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }


    public function create(array $data)
    {
        return $this->model->create($data);
    }


    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function delete(int $id)
    {
        $record = $this->find($id);
        return $record ? $record->delete() : false;
    }
}
