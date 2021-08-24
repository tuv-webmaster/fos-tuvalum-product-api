<?php

namespace App\Domain\Brand\Find;

class FindBrandQuery
{
    /**
     * @var string
     */
    private $uuid;

    public function __construct(string $uuid)
    {

        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

}
