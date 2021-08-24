<?php

namespace App\Domain\Model;

use App\Domain\Brand\BrandInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table("model")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\ModelRepository")
 */
class Model implements ModelInterface
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
     * @var string
     *
     * @ORM\Column(name="name", length=50, type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(name="url", type="string", nullable=true)
     */
    protected $url;

    /**
     * Many Models have One Brand.
     *
     * @ORM\ManyToOne(targetEntity="\App\Domain\Brand\Brand", inversedBy="models")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="uuid")
     */
    protected $brand;

    /**
     * Many Models have One Category.
     *
     * @ORM\ManyToOne(targetEntity="\App\Domain\Category\Category", inversedBy="models")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="uuid")
     */
    protected $category;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @param UuidInterface $uuid
     */
    public function setUuid(UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand(BrandInterface $brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getSlogan()
    {
        return $this->translate()->getSlogan();
    }

    public function setSlogan(string $slogan)
    {
        $this->translate(null, false)->setSlogan($slogan);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->translate()->getDescription();
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->translate(null, false)->setDescription($description);
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->translate()->getShortDescription();
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->translate(null, false)->setShortDescription($shortDescription);
    }

    public function getSluggableFields()
    {
        return ['name'];
    }

    /**
     * Returns whether or not the slug gets regenerated on update.
     *
     * @return bool
     */
    private function getRegenerateSlugOnUpdate()
    {
        return false;
    }

    public function setLocale($locale)
    {
        $this->setCurrentLocale($locale);
    }

    public function getLocale()
    {
        return $this->getCurrentLocale();
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

}
