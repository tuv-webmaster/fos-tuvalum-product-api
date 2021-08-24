<?php
declare(strict_types=1);

namespace App\Shared\Domain\Translation;


class TranslationCollectionDto implements \Iterator
{
    /**
     * @var TranslationDto[]|iterable
     */
    private $translations;

    /**
     * @param TranslationDto[] $translations
     */
    public function __construct(iterable $translations){
        $this->translations = $translations;
    }

    /**
     * @param TranslationDto[] $translations
     */
    public static function create(iterable $translations)
    {
        return new static($translations);
    }

    function rewind() {
        return reset($this->translations);
    }
    function current() {
        return current($this->translations);
    }
    function key() {
        return key($this->translations);
    }
    function next() {
        return next($this->translations);
    }
    function valid() {
        return key($this->translations) !== null;
    }
//
//    /**
//     * @return TranslationDto[]
//     */
//    public function getTranslations(): iterable
//    {
//        return $this->translations;
//    }
//
//    /**
//     * @param TranslationDto[] $translations
//     */
//    public function setTranslations(iterable $translations): void
//    {
//        $this->translations = $translations;
//    }
}
