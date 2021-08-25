<?php
declare(strict_types=1);

namespace App\Application\Controller\Brand;

use App\Domain\Brand\Create\CreateBrandCommand;

use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateBrandController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var
     */
    private $validator;

    public function __construct(
        MessageBusInterface $commandBus,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->validator = $validator;
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
    public function __invoke(Request $request): Response
    {
        $requestContent = $request->getContent();
        $createCommand = $this->serializer->deserialize($requestContent, CreateBrandCommand::class, 'json');

        $violations = $this->validator->validate($createCommand);

        if (count($violations) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $violations;

            return new Response($errorsString, 400);
        }

        $this->commandBus->dispatch($createCommand);

        return new Response('',  200);
    }
}
