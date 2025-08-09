<?php

namespace App\Domain\Subject\Repositories;

use App\Domain\Subject\Models\Subject;
use App\Domain\Subject\DataTransferObjects\SubjectData;

class SubjectRepository
{
    public function getAll()
    {
        return Subject::all();
    }

    public function find(int $id)
    {
        return Subject::findOrFail($id);
    }

    public function create(SubjectData $data)
    {
        return Subject::create((array) $data);
    }

    public function update(int $id, SubjectData $data)
    {
        $model = Subject::findOrFail($id);
        $model->update((array) $data);
        return $model;
    }

    public function delete(int $id)
    {
        return Subject::destroy($id);
    }
}
