<?php
declare(strict_types=1);

namespace App\Application\Controller\Brand;

use App\Domain\Brand\Create\CreateBrandCommand;

use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class CreateBrandController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Creates a brand resource.
     *
     * Long Description.
     *
     * @Route("/api/brands", methods={"PUT"})
     * @OA\Response(
     *     response=200,
     *     description="Creates a new brand resource",
     *     @Model(type=CreateBrandCommand::class)
     * )
     * @OA\Parameter (
     *     in="query",
     *     name="NewBrand",
     *     description="Input Brand object",
     *     @Model(type=CreateBrandCommand::class)
     * )
     * @OA\Tag(name="Brands")
     * @Security(name="Bearer")
     */
    public function __invoke(Request $request): CreateBrandCommand
    {
        $this->commandBus->handle($request);

        return new Response();
    }
}
