<?php

namespace App\Domain\Brand;

use App\Domain\Category\CategoryInterface;
use App\Domain\Model\ModelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * Entity Brand.
 *
 * @ORM\Table("brand", uniqueConstraints={@ORM\UniqueConstraint(name="uuid_unq", columns={"uuid"})})
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\BrandRepository")
 */
class Brand implements BrandInterface
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
     * @ORM\Column(name="name", length=50, type="string", nullable=false, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(name="url", type="string", nullable=true)
     */
    protected $url;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\App\Domain\Category\Category", mappedBy="brands")
     * @ORM\JoinTable(name="category_brands",
     *     joinColumns={
     *         @ORM\JoinColumn(name="brand_id", referencedColumnName="uuid")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="category_id", referencedColumnName="uuid")
     *     }
     *
     * )
     */
    protected $categories;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="\App\Domain\Model\Model", mappedBy="brand")
     */
    private $models;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="smallint", nullable=true)
     */
    protected $position;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->models = new ArrayCollection();
        $this->routes = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getName();
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
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid): void
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
     * @return mixed
     */
    public function getAlerta()
    {
        return $this->alerta;
    }

    /**
     * @param mixed $alerta
     */
    public function setAlerta($alerta)
    {
        $this->alerta = $alerta;
    }

    public function addCategory(CategoryInterface $category)
    {
        if (!$this->categories->contains($category)) {
            $category->addBrand($this);
            $this->categories->add($category);
        }
    }

    public function removeCategory(CategoryInterface $category)
    {
        if ($this->categories->contains($category)) {
            $category->removeBrand($this);
            $this->categories->removeElement($category);
        }
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $models
     */
    public function setModels($models)
    {
        $this->models = $models;
    }

    public function addModel(ModelInterface $model)
    {
        if (!$this->models->contains($model)) {
            $model->setBrand($this);
            $this->models->add($model);
        }
    }

    public function removeModel(ModelInterface $model)
    {
        if ($this->models->contains($model)) {
            $model->setBrand(null);
            $this->models->removeElement($model);
        }
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
        return is_null($this->slug);
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

    public function setDescription(string $description)
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

    public function setShortDescription(string $shortDescription)
    {
        $this->translate(null, false)->setShortDescription($shortDescription);
    }

    public function getPosition(): int
    {
        return (int)$this->position;
    }

    public function setPosition(int $position)
    {
        $this->position = $position;
    }

    public function setLocale($locale)
    {
        $this->setCurrentLocale($locale);
    }

    public function getLocale()
    {
        return $this->getCurrentLocale();
    }

    public function findTranslation($locale)
    {
        return $this->findTranslationByLocale($locale);
    }

    public function hasBikeCategory()
    {
        foreach ($this->categories as $category) {
            if ($category->isABike()) {
                return true;
            }
        }

        return false;
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

    /**
     * Set important.
     *
     * @param bool $important
     */
    public function setImportant($important)
    {
        $this->translate(null, false)->setImportant($important);
    }

    /**
     * Get important.
     *
     * @return bool
     */
    public function getImportant()
    {
        return $this->translate()->getImportant();
    }

    /**
     * Set localePosition.
     *
     * @param int $localePosition
     */
    public function setLocalePosition($localePosition)
    {
        $this->translate(null, false)->setLocalePosition($localePosition);
    }

    /**
     * Get localePosition.
     *
     * @return int
     */
    public function getLocalePosition()
    {
        return $this->translate()->getLocalePosition();
    }

    public function isUnknownBrand()
    {
        return BrandInterface::ANOTHER_BRAND_ID == $this->id;
    }
}
