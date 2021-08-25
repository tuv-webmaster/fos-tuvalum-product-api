<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Brand\Brand;
use App\Domain\Brand\BrandDto;
use App\Shared\Domain\Translation\TranslationDto;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

class BrandToBrandOutput implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(Brand::class, BrandDto::class)
            ->forMember('url', function (Brand $source) {
                return [new TranslationDto('es_ES', $source->getUrl())];
            })
            ->forMember('slogan', function (Brand $source) {
                return [new TranslationDto('es_ES', $source->getUrl())];
            })
            ->forMember('description', function (Brand $source) {
                return [new TranslationDto('es_ES', $source->getUrl())];
            })
            ->forMember('shortDescription', function (Brand $source) {
                return [new TranslationDto('es_ES', $source->getUrl())];
            })
            ->forMember('important', function (Brand $source) {
                return [new TranslationDto('es_ES', $source->getUrl())];
            })
            ->forMember('position', function (Brand $source) {
                return [new TranslationDto('es_ES', $source->getPosition())];
            });

        // And so on..
    }
}
