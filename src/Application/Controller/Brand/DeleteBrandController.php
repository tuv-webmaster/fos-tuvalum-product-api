<?php
declare(strict_types=1);

namespace App\Application\Controller\Brand;

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

class DeleteBrandController extends AbstractController
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
     * @param MessageBusInterface $commandBus
     * @param ValidatorInterface $validator
     *
     */
    public function __construct(MessageBusInterface $commandBus, ValidatorInterface $validator)
    {

        $this->commandBus = $commandBus;
        $this->validator = $validator;
    }

    /**
     * Deletes a brand resource.
     *
     * Long Description.
     *
     * @Route("/api/brands/{uuid}", methods={"DELETE"})
     *
     *  @OA\Delete(
     *     path="/api/brands/{uuid}",
     *     @OA\Response(
     *          response=200,
     *          description="Operation OK"
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
            return $result;
        }
        throw new NotFoundHttpException();
        return new Response('Not found', 404);
    }
}
