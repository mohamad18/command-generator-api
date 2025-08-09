<?php

namespace App\Domain\School\DataTransferObjects;

class SchoolData
{
    public function __construct(
        // definisikan property di sini, misal:
        public string $name = '',
        public string $address = ''
    ) {}
}
