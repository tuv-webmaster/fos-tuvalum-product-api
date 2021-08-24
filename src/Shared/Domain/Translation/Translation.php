<?php

namespace App\Shared\Domain\Translation;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass="App\Shared\Domain\Translation\TranslationRepository")
 */
class Translation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid_binary", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domain;
    /**
     * @ORM\Column(type="string", length=2)
     */
    private $locale;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $key;
    /**
     * @ORM\Column(type="text")
     */
    private $translation;

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }
    /**
     * @param string $domain
     *
     * @return Translation
     */
    public function setDomain(string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }
    /**
     * @param string $locale
     *
     * @return Translation
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }
    /**
     * @param string $key
     *
     * @return Translation
     */
    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getTranslation(): ?string
    {
        return $this->translation;
    }
    /**
     * @param string $translation
     *
     * @return Translation
     */
    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;
        return $this;
    }
}
