<?php

namespace App\Domain\School\Repositories;

use App\Domain\School\Models\School;
use App\Domain\School\DataTransferObjects\SchoolData;

class SchoolRepository
{
    public function getAll()
    {
        return School::all();
    }

    public function find(int $id)
    {
        return School::findOrFail($id);
    }

    public function create(SchoolData $data)
    {
        return School::create((array) $data);
    }

    public function update(int $id, SchoolData $data)
    {
        $model = School::findOrFail($id);
        $model->update((array) $data);
        return $model;
    }

    public function delete(int $id)
    {
        return School::destroy($id);
    }
}
