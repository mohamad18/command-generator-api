<?php

namespace App\Domain\Subject\DataTransferObjects;

class SubjectData
{
    public function __construct(
        // definisikan property di sini, misal:
        public string $school_id,
        public string $name = '',
        public string $description = ''
    ) {}
}
