<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Brand\Brand;
use App\Domain\Brand\Create\CreateBrandCommand;
use App\Domain\Brand\OutputBrandDto;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use Ramsey\Uuid\Uuid;

class NewBrandCommandToBrand implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(CreateBrandCommand::class, Brand::class)
            ->forMember('url', function (CreateBrandCommand $source) {
                return $source->getUrl()[0]->getMessage();
            })
            ->forMember('uuid', function (CreateBrandCommand $source) {
                return Uuid::uuid4();
            })
            ->forMember('position', function (CreateBrandCommand $source) {
                return 0;
            });

        // And so on..
    }
}
