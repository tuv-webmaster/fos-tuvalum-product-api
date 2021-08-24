<?php

namespace App\Shared\Domain\Translation;

use OpenApi\Annotations as OA;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;

class TranslationDto
{
    /**
     * Locale iso as string.
     *
     * @var string
     * @JMS\Type("string")
     * @OA\Property(description="Language locale iso as string.", example="es_ES")
     */
    private $locale;

    /**
     * @var string
     * @JMS\Type("string")
     * @OA\Property(description="Localized text.", example="La mejor marca del mundo!")
     */
    private $message;

    public function __construct(string $locale, string $message)
    {
        $this->locale = $locale;
        $this->message = $message;
    }

    /**
     * Locale iso as string.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
