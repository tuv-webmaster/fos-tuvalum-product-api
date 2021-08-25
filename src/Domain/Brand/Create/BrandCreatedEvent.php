<?php
declare(strict_types=1);

namespace App\Domain\Brand\Create;

class BrandCreatedEvent
{
    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    public static function create(string $uuid): self
    {
        return new static($uuid);
    }
}
