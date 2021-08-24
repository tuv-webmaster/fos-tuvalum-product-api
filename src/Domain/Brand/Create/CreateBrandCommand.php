<?php
declare(strict_types=1);

namespace App\Domain\Brand\Create;
use JMS\Serializer\Annotation\AccessType;
use App\Domain\CommandInterface;
use App\Domain\Brand\InputBrandDto;

class CreateBrandCommand extends InputBrandDto implements CommandInterface
{

}
