<?php
declare(strict_types=1);

namespace App\Shared\Domain\Translation;

/**
 * @package \App\Shared\Domain\Translation
 */
interface TranslatorAdapterInterface
{
    /**
     * Translates a key into desired locale.
     *
     * @param string $domain
     * @param string $locale
     * @param string $key
     *
     * @return string
     */
    public function trans(string $domain, string $locale, string $key): string;
}
