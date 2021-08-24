<?php

namespace App\Domain\Brand;

use App\Shared\Domain\Translation\TranslationCollectionDto;
use App\Shared\Domain\Translation\TranslationDto;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation("self", href = "expr('/api/users/' ~ object.getUuid())")
 * @Hateoas\Relation("models", href = "expr('/api/brands/' ~ object.getUuid())/models")
 */
class BrandDto extends InputBrandDto
{
    /**
     * @JMS\Type("string")
     * @OA\Property(description="The unique identifier of the brand.", example="123e4567-e89b-12d3-a456-426655440000")
     *
     * @var string
     */
    protected $uuid;
}
