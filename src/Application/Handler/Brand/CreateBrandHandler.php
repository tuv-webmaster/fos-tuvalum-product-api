<?php
declare(strict_types=1);

namespace App\Application\Handler\Brand;
use App\Domain\Brand\Create\CreateBrandHandler as DomainCreateBrandHandler;

use App\Domain\Brand\Find\FindBrandQuery;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateBrandHandler extends DomainCreateBrandHandler implements MessageHandlerInterface
{

}
