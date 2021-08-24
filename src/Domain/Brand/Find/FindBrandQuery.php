<?php

namespace App\Domain\Brand\Find;

class FindBrandQuery
{
    public function __construct(private string $uuid)
    {

    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

}
