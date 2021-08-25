<?php

namespace App\Domain\Brand\Create;

use App\Domain\Brand\Brand;
use App\Infrastructure\Repository\BrandRepository;
use AutoMapperPlus\AutoMapperInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateBrandService
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

    public function __construct(
        BrandRepository $brandRepository,
        MessageBusInterface $eventBus,
        LoggerInterface $logger
    ) {
        $this->brandRepository = $brandRepository;
        $this->logger = $logger;
        $this->eventBus = $eventBus;
    }

    public function create(Brand $brand)
    {
        $this->brandRepository->persist($brand);

        $brandCreatedEvent = BrandCreatedEvent::create("uuid");
        // $this->eventBus->dispatch($brandCreatedEvent);

        $this->logger->info('New brand created', [
            'uuid' => $brand->getUuid(),
            'name' => $brand->getName()
        ]);
    }
}
