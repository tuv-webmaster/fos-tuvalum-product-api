<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Brand\Brand;
use App\Domain\Brand\OutputBrandDto;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

class BrandToBrandOutput implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(Brand::class, OutputBrandDto::class)
            ->forMember('url', function (Brand $source) {
                return [ 'es_ES' => $source->getUrl() ];
            })
            ->forMember('position', function (Brand $source) {
                return [ 'es_ES' => $source->getPosition() ];
            });

        // And so on..
    }
}
