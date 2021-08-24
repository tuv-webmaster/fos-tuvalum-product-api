<?php

namespace App\Application\Controller\Model;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class DeleteModelController
{
    /**
     * Creates or replaces a model resource.
     *
     * Long Description.
     *
     * @Route("/api/brands/{brand-uuid}/models/{uuid}", methods={"DELETE"})
     *
     *  @OA\Put(
     *     path="/api/brands/{brand-uuid}/models/{uuid}",
     *     @OA\Response(
     *          response=200,
     *          description="Resource deleted succesfully",
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
    public function __invoke(Model $model)
    {
        // TODO: Implement __invoke() method.
    }
}
