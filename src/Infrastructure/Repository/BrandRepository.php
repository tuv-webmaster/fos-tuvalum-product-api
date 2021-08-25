<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Brand\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    public function persist(Brand $brand)
    {
        $this->getEntityManager()->persist($brand);
        $this->getEntityManager()->flush();
    }
}
