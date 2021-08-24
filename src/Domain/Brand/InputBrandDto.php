<?php

namespace App\Domain\Brand;

use App\Shared\Domain\Translation\TranslationCollectionDto;
use App\Shared\Domain\Translation\TranslationDto;
use OpenApi\Annotations as OA;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;

class InputBrandDto
{
    /**
     * @var string
     * @JMS\Type("string")
     * @OA\Property(description="Known name of the brand.", example="Orbea")
     */
    protected $name;

    /**
     * Translated brand access urls.
     *
     * @var TranslationDto[]
     * @JMS\Type("array<TranslationDto>")
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref=@Model(type=TranslationDto::class))
     * )
     */
    protected $url;

    /**
     * Translated slogans.
     *
     * @var TranslationDto[]
     * @JMS\Type("array<TranslationDto>")
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref=@Model(type=TranslationDto::class))
     * )
     */
    protected $slogan;

    /**
     * Translated descriptions.
     *
     * @var TranslationDto[]
     * @JMS\Type("array<TranslationDto>")
     * @OA\Property(
     *     description="Translated brand description.",
     *     type="array",
     *     @OA\Items(ref=@Model(type=TranslationDto::class))
     * )
     */
    protected $description;

    /**
     * Translated brand short descriptions.
     *
     * @var TranslationDto[]
     * @JMS\Type("array<TranslationDto>")
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref=@Model(type=TranslationDto::class))
     * )
     */
    protected $shortDescription;

    /**
     * Brand importance by localization
     *
     * @var TranslationDto[]
     * @JMS\Type("array<TranslationDto>")
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref=@Model(type=TranslationDto::class))
     * )
     */
    protected $important;

    /**
     * Brand position by localization
     *
     * @var TranslationDto[]
     * @JMS\Type("array<TranslationDto>")
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref=@Model(type=TranslationDto::class))
     * )
     */
    protected $position;

    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return TranslationDto[]
     */
    public function getUrl(): iterable
    {
        return $this->url;
    }

    /**
     * @return TranslationCollectionDto
     */
    public function getSlogan(): iterable
    {
        return $this->slogan;
    }

    /**
     * @return TranslationCollectionDto
     */
    public function getDescription(): iterable
    {
        return $this->description;
    }

    /**
     * @return TranslationCollectionDto
     */
    public function getShortDescription(): iterable
    {
        return $this->shortDescription;
    }

    /**
     * @return TranslationCollectionDto
     */
    public function getImportant(): iterable
    {
        return $this->important;
    }

    /**
     * @return TranslationCollectionDto
     */
    public function getPosition(): iterable
    {
        return $this->position;
    }
}
