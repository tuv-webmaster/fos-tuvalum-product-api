<?php

namespace App\Domain\Brand\Create;

use App\Domain\Brand\Find\FindBrandQuery;

class CreateBrandHandler
{
    public function __construct()
    {

    }

    public function __invoke(CreateBrandCommand $findBrandsQuery)
    {
        var_dump($findBrandsQuery);
    }
}
