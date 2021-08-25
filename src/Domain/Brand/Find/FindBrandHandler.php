<?php

namespace App\Domain\Brand\Find;

use App\Domain\Brand\BrandDto;
use App\Infrastructure\Repository\BrandRepository;
use AutoMapperPlus\AutoMapperInterface;

class FindBrandHandler
{
    /**
     * @var BrandRepository
     */
    private $brandRepository;
    /**
     * @var AutoMapperInterface
     */
    private $mapper;

    public function __construct(BrandRepository $brandRepository, AutoMapperInterface $mapper)
    {
        $this->brandRepository = $brandRepository;
        $this->mapper = $mapper;
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
