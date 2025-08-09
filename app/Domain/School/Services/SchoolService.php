<?php

namespace App\Domain\School\Services;

use App\Domain\School\Repositories\SchoolRepository;
use App\Domain\School\DataTransferObjects\SchoolData;

class SchoolService
{
    public function __construct(private SchoolRepository $repository) {}

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
        $dto = new SchoolData(...$data);
        return $this->repository->create($dto);
    }

    public function update(int $id, array $data)
    {
        $dto = new SchoolData(...$data);
        return $this->repository->update($id, $dto);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
