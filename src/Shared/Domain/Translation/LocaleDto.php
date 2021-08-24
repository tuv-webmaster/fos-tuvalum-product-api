<?php
declare(strict_types=1);

namespace App\Shared\Domain\Translation;

class LocaleDto
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale)
    {

        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

}
