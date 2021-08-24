<?php
declare(strict_types=1);

namespace App\Shared\Domain\Translation;

use App\Shared\Domain\Translation\TranslatorAdapterInterface;
use App\Shared\Infrastructure\Adapter\DatabaseTranslatorAdapter;

class TranslatorService
{
    public function __construct(DatabaseTranslatorAdapter $translator)
    {

    }

    public function getTranslationCollection($domain, $key)
    {
        $this->translator->getTranslations($domain, $key);

    }

}
