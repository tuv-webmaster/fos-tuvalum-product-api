<?php

namespace App\Shared\Infrastructure\Adapter;

use App\Shared\Domain\Translation\TranslatorAdapterInterface;

class DatabaseTranslatorAdapter implements TranslatorAdapterInterface
{
    public function trans(string $domain, string $locale, string $key): string
    {
        return $key;
    }
}
