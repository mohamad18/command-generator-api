<?php

namespace App\Domain\Subject\Services;

use App\Domain\Subject\Repositories\SubjectRepository;
use App\Domain\Subject\DataTransferObjects\SubjectData;

class SubjectService
{
    public function __construct(private SubjectRepository $repository) {}

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        $dto = new SubjectData(...$data);
        return $this->repository->create($dto);
    }

    public function update(int $id, array $data)
    {
        $dto = new SubjectData(...$data);
        return $this->repository->update($id, $dto);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
