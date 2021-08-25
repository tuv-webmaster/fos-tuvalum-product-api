<?php
declare(strict_types=1);

namespace App\Application\Controller\Brand;

use App\Domain\Brand\BrandDto;

use App\Application\Problems\NotFoundProblem;
use App\Domain\Brand\Find\FindBrandQuery;
use JMS\Serializer\SerializerInterface;
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

class GetBrandController extends AbstractController
{

    /**
     * @var MessageBusInterface
     */
    private $commandBus;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param MessageBusInterface $commandBus
     * @param ValidatorInterface $validator
     *
     */
    public function __construct(
        MessageBusInterface $commandBus,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {

        $this->commandBus = $commandBus;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * Returns a brand resource.
     *
     * Long Description.
     *
     * @Route("/api/brands/{uuid}", methods={"GET"})
     *
     *  @OA\Get(
     *     path="/api/brands/{uuid}",
     *     @OA\Response(
     *          response=200,
     *          description="Returns a brand resource",
     *          @Model(type=BrandDto::class)
     *     ),
     *     @OA\Parameter (
     *          in="path",
     *          name="uuid",
     *          required=true,
     *          description="Brand uuid identifier",
     *     ),
     *     @Security(name="Bearer")
     * )
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
            return new Response($this->serializer->serialize($result, 'json'), 200);
        }
        return new Response('Not found', 404);
    }
}
