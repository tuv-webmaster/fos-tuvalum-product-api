<?php

namespace App\Domain\Brand\Find;

use App\Domain\Brand\BrandDto;
use App\Infrastructure\Repository\BrandRepository;
use AutoMapperPlus\AutoMapperInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FindBrandHandler
{
    public function __construct(BrandRepository $brandRepository, AutoMapperInterface $mapper)
    {

    }

    public function __invoke(FindBrandQuery $findBrandsQuery)
    {
        // var_dump($findBrandsQuery);
        $brand = $this->brandRepository->findOneBy(['uuid' => $findBrandsQuery->getUuid()]);

        if (true === empty($brand)) {
            return;
        }
        // echo get_class($brand); die();
        $brandDto = $this->mapper->map($brand, BrandDto::class);

        return $brandDto;
    }
}
