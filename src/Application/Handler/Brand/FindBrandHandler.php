<?php
declare(strict_types=1);

namespace App\Application\Handler\Brand;
use App\Domain\Brand\Find\FindBrandHandler as DomainFindBrandHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FindBrandHandler extends DomainFindBrandHandler implements MessageHandlerInterface
{

}
