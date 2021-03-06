<?php

namespace App\Domain\Brand\Create;

use App\Domain\Brand\Brand;
use App\Domain\Brand\BrandDto;
use App\Domain\Brand\Find\FindBrandQuery;
use App\Infrastructure\Repository\BrandRepository;
use AutoMapperPlus\AutoMapperInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateBrandHandler
{
    /**
     * @var BrandRepository
     */
    private $brandRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var MessageBusInterface
     */
    private $eventBus;
    /**
     * @var AutoMapperInterface
     */
    private $mapper;
    /**
     * @var CreateBrandService
     */
    private $brandService;

    public function __construct(
        BrandRepository $brandRepository,
        MessageBusInterface $eventBus,
        AutoMapperInterface $mapper,
        CreateBrandService $brandService,
        LoggerInterface $logger
    ) {

        $this->brandRepository = $brandRepository;
        $this->logger = $logger;
        $this->eventBus = $eventBus;
        $this->mapper = $mapper;
        $this->brandService = $brandService;
    }

    public function __invoke(CreateBrandCommand $findBrandsQuery)
    {
        $brand = $this->mapper->map($findBrandsQuery, Brand::class);

        $this->brandService->create($brand);
    }
}
