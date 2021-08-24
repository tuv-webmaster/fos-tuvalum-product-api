<?php
declare(strict_types=1);

namespace App\Shared\Domain\Translation;

class LocaleDto
{
    public function __construct(private string $locale)
    {

    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

}
