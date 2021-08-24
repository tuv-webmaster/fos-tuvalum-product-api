<?php
declare(strict_types=1);

namespace App\Application\Controller\Model;

use App\Domain\Brand\BrandDto;

use App\Application\Problems\NotFoundProblem;
use App\Domain\Brand\Find\FindBrandQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class PatchModelController
{

    /**
     * @var MessageBusInterface
     */
    private $commandBus;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(MessageBusInterface $commandBus, ValidatorInterface $validator)
    {

        $this->commandBus = $commandBus;
        $this->validator = $validator;
    }

    /**
     * Returns a model resource.
     *
     * Long Description.
     *
     * @Route("/api/brands/{brand-uuid}/models/{uuid}", methods={"PATCH"})
     *
     *  @OA\Patch (
     *     path="/api/brands/{brand-uuid}/models/{uuid}",
     *     @OA\Response(
     *          response=200,
     *          description="Returns a modified model resource",
     *          @Model(type=BrandDto::class)
     *     ),
     *     @OA\Parameter (
     *          in="path",
     *          name="brand-uuid",
     *          required=true,
     *          description="Brand uuid identifier",
     *     ),
     *     @OA\Parameter (
     *          in="path",
     *          name="uuid",
     *          description="Model uuid identifier",
     *     ),
     *     @OA\Tag(name="Brands"),
     *     @Security(name="Bearer")
     *  )
     * @OA\Tag(name="Brands")
     */
    public function __invoke(string $uuid)
    {
        $brandQuery = new FindBrandQuery($uuid);

        $violations = $this->validator->validate($brandQuery);
        $envelope = $this->commandBus->dispatch($brandQuery);

        /**
         * @var StampInterface
         */
        $handledStamp = $envelope->last(HandledStamp::class);
        $result = $handledStamp->getResult();

        if (false === empty($result)) {
            return $result;
        }
        throw new NotFoundHttpException();
        return new Response('Not found', 404);
    }
}
