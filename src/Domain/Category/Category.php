<?php

namespace App\Domain\Category;

use App\Domain\Brand\BrandInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * Entity Category.
 *
 * @ORM\Table("category")
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\CategoryRepository")
 */
class Category implements CategoryInterface
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
     * @ORM\Column(name="OldProductSlug", type="string", nullable=true)
     */
    protected $oldProductSlug;

    /**
     * @ORM\Column(name="alias", type="string", nullable=true)
     */
    protected $alias;

    /**
     * @ORM\Column(name="url", type="string", nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    protected $enabled;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\App\Domain\Brand\Brand", inversedBy="categories")
     * @ORM\JoinTable(name="category_brands",
     *     joinColumns={
     *         @ORM\JoinColumn(name="category_id", referencedColumnName="uuid")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="brand_id", referencedColumnName="uuid")
     *     }
     * )
     **/
    private $brands;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="uuid", onDelete="SET NULL")
     **/
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="main_category")
     **/
    private $last_children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="last_children")
     * @ORM\JoinColumn(name="main_category_id", referencedColumnName="uuid", onDelete="SET NULL")
     **/
    private $main_category;

    /**
     * @ORM\OneToMany(targetEntity="\App\Domain\Model\Model", mappedBy="category")
     */
    private $models;


    private $nProducts;

    public function __construct()
    {
        $this->enabled = 1;
        $this->children = new ArrayCollection();
        $this->last_children = new ArrayCollection();
        $this->brands = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    public function getType()
    {
        switch ($this->getUuid()) {
            case CategoryInterface::ROAD_BIKE_CATEGORY_ID:
            case CategoryInterface::PARENT_BIKE_CATEGORY_ID:
            case CategoryInterface::MOUNTAIN_BIKE_CATEGORY_ID:
            case CategoryInterface::TRIATHLON_BIKE_CATEGORY_ID:
            case CategoryInterface::ELECTRIC_BIKE_CATEGORY_ID:
            case CategoryInterface::MOUNTAIN_E_BIKE_CATEGORY_ID:
            case CategoryInterface::ROAD_E_BIKE_CATEGORY_ID:
            case CategoryInterface::URBAN_E_BIKE_CATEGORY_ID:
            case CategoryInterface::CROSS_BIKE_CATEGORY_ID:
                return CategoryInterface::TYPE_BIKE;
                break;

            case CategoryInterface::COMPONENT_CATEGORY_ID:
            case CategoryInterface::WHEEL_CATEGORY_ID:
            case CategoryInterface::ROAD_WHEEL_CATEGORY_ID:
            case CategoryInterface::MOUNTAIN_WHEEL_CATEGORY_ID:
            case CategoryInterface::FRAME_CATEGORY_ID:
            case CategoryInterface::ROAD_FRAME_CATEGORY_ID:
            case CategoryInterface::MOUNTAIN_FRAME_CATEGORY_ID:
            case CategoryInterface::HANDLEBAR_CATEGORY_ID:
            case CategoryInterface::SEAT_BIKE_CATEGORY_ID:
            case CategoryInterface::FORK_CATEGORY_ID:
            case CategoryInterface::CRANK_ARM_CATEGORY_ID:
            case CategoryInterface::SHIFTER_CATEGORY_ID:
            case CategoryInterface::OTHER_COMPONENTS_CATEGORY_ID:
            case CategoryInterface::STEM_CATEGORY_ID:
                return CategoryInterface::TYPE_COMPONENT;
                break;

            case CategoryInterface::ACCESSORY_CATEGORY_ID:
            case CategoryInterface::HELMET_CATEGORY_ID:
            case CategoryInterface::GPS_CATEGORY_ID:
            case CategoryInterface::ROLLER_CATEGORY_ID:
            case CategoryInterface::SHOES_CATEGORY_ID:
            case CategoryInterface::OTHER_ACCESSORIES_CATEGORY_ID:
                return CategoryInterface::TYPE_ACCESSORY;

            case CategoryInterface::NEOPRENE_CATEGORY_ID:
                return CategoryInterface::TYPE_OTHER;

            default:
                throw new \InvalidArgumentException('Unknown category');
        }
    }

    public function getProductType()
    {
        switch ($this->getUuid()) {
            case CategoryInterface::ROAD_BIKE_CATEGORY_ID:
                return 'BCarretera';
                break;
            case CategoryInterface::MOUNTAIN_BIKE_CATEGORY_ID:
                return 'BMontanya';
                break;
            case CategoryInterface::TRIATHLON_BIKE_CATEGORY_ID:
                return 'BTriatlon';
                break;
            case CategoryInterface::MOUNTAIN_E_BIKE_CATEGORY_ID:
                return 'MountainEBike';
                break;
            case CategoryInterface::ROAD_E_BIKE_CATEGORY_ID:
                return 'RoadEBike';
                break;
            case CategoryInterface::URBAN_E_BIKE_CATEGORY_ID:
                return 'UrbanEBike';
                break;
            case CategoryInterface::CROSS_BIKE_CATEGORY_ID:
                return 'CrossBike';
                break;
            case CategoryInterface::ROAD_WHEEL_CATEGORY_ID:
                return 'RCarretera';
                break;
            case CategoryInterface::MOUNTAIN_WHEEL_CATEGORY_ID:
                return 'RMontanya';
                break;
            case CategoryInterface::ROAD_FRAME_CATEGORY_ID:
                return 'CCarretera';
                break;
            case CategoryInterface::MOUNTAIN_FRAME_CATEGORY_ID:
                return 'CMontanya';
                break;
            case CategoryInterface::FORK_CATEGORY_ID:
                return 'Horquillas';
                break;
            case CategoryInterface::HELMET_CATEGORY_ID:
                return 'Cascos';
                break;
            case CategoryInterface::SHOES_CATEGORY_ID:
                return 'Zapatillas';
                break;
            default:
                return 'product';
                break;
        }
    }

    public function isABike()
    {
        return $this->isBike() || $this->isMountainBike() || $this->isEMountainBike() || $this->isRoadBike()
            || $this->isERoadBike() || $this->isTriatlonBike() || $this->isUrbanBike() || $this->isCrossBike();
    }

    public function isBike()
    {
        return CategoryInterface::TYPE_BIKE === $this->getType();
    }

    public function isMountainBike()
    {
        return in_array($this->getUuid(), [CategoryInterface::MOUNTAIN_BIKE_CATEGORY_ID]);
    }

    public function isEMountainBike()
    {
        return in_array($this->getUuid(), [CategoryInterface::MOUNTAIN_E_BIKE_CATEGORY_ID]);
    }

    public function isRoadBike()
    {
        return in_array($this->getUuid(), [CategoryInterface::ROAD_BIKE_CATEGORY_ID]);
    }

    public function isERoadBike()
    {
        return in_array($this->getUuid(), [CategoryInterface::ROAD_E_BIKE_CATEGORY_ID]);
    }

    public function isTriatlonBike()
    {
        return in_array($this->getUuid(), [CategoryInterface::TRIATHLON_BIKE_CATEGORY_ID]);
    }

    public function isUrbanBike()
    {
        return in_array($this->getUuid(), [CategoryInterface::URBAN_E_BIKE_CATEGORY_ID]);
    }

    public function isCrossBike()
    {
        return in_array($this->getUuid(), [CategoryInterface::CROSS_BIKE_CATEGORY_ID]);
    }

    public function isRoller()
    {
        return in_array($this->getUuid(), [CategoryInterface::ROLLER_CATEGORY_ID]);
    }

    public function isGps()
    {
        return in_array($this->getUuid(), [CategoryInterface::GPS_CATEGORY_ID]);
    }

    public function isShoe()
    {
        return in_array($this->getUuid(), [CategoryInterface::SHOES_CATEGORY_ID]);
    }

    public function isHelmet()
    {
        return in_array($this->getUuid(), [CategoryInterface::HELMET_CATEGORY_ID]);
    }

    public function isDisk()
    {
        return in_array($this->getUuid(), [CategoryInterface::CRANK_ARM_CATEGORY_ID]);
    }

    public function isRoadWheel()
    {
        return in_array($this->getUuid(), [CategoryInterface::ROAD_WHEEL_CATEGORY_ID]);
    }

    public function isMountainWheel()
    {
        return in_array($this->getUuid(), [CategoryInterface::MOUNTAIN_WHEEL_CATEGORY_ID]);
    }

    public function isGenericWheel()
    {
        return in_array($this->getUuid(), [CategoryInterface::WHEEL_CATEGORY_ID]);
    }

    public function isGenericFrame()
    {
        return in_array($this->getUuid(), [CategoryInterface::FRAME_CATEGORY_ID]);
    }

    public function isRoadFrame()
    {
        return in_array($this->getUuid(), [CategoryInterface::ROAD_FRAME_CATEGORY_ID]);
    }

    public function isMountainFrame()
    {
        return in_array($this->getUuid(), [CategoryInterface::MOUNTAIN_FRAME_CATEGORY_ID]);
    }

    public function isSeat()
    {
        return in_array($this->getUuid(), [CategoryInterface::SEAT_BIKE_CATEGORY_ID]);
    }

    public function isMainGroup()
    {
        return in_array($this->getUuid(), [CategoryInterface::SHIFTER_CATEGORY_ID]);
    }

    public function isHandlebar()
    {
        return in_array($this->getUuid(), [CategoryInterface::HANDLEBAR_CATEGORY_ID]);
    }

    public function isComponent()
    {
        return CategoryInterface::TYPE_COMPONENT === $this->getType();
    }

    public function isAccessory()
    {
        return CategoryInterface::TYPE_ACCESSORY === $this->getType();
    }

    public function isOtherType()
    {
        return CategoryInterface::TYPE_OTHER === $this->getType();
    }

    public function isEBike()
    {
        return in_array($this->getUuid(), [CategoryInterface::ELECTRIC_BIKES_CATEGORIES_IDS]);
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
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Get id.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Add children.
     *
     * @param \App\Entity\Category $children
     *
     * @return Category
     */
    public function addChild(Category $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children.
     *
     * @param \App\Entity\Category $children
     */
    public function removeChild(Category $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent.
     *
     * @param \App\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \App\Entity\Category
     */
    public function getDirectParent()
    {
        return $this->parent;
    }

    /**
     * Get parent.
     *
     * @return \App\Entity\Category
     *
     * @deprecated
     */
    public function getParent()
    {
        return $this->main_category;
    }

    /**
     * Set main_category.
     *
     * @param \App\Entity\Category $main_category
     *
     * @return Category
     */
    public function setMainCategory(Category $main_category = null)
    {
        $this->main_category = $main_category;

        return $this;
    }

    /**
     * Get main_category.
     *
     * @return \App\Entity\Category
     */
    public function getMainCategory()
    {
        return $this->main_category;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->translate(null, false)->setName($name);

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->translate()->getName();
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->translate(null, false)->setSlug($slug);

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->translate()->getSlug();
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getBrands()
    {
        return $this->brands;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $brands
     */
    public function setBrands($brands)
    {
        $this->brands = $brands;
    }

    public function addBrand(BrandInterface $brand)
    {
        if (!$this->brands->contains($brand)) {
            //If you discomment this and perform and addCategory call in Brand entity, you'll get and infinity loop
            //$brand->addCategory($this);
            $this->brands->add($brand);
        }
    }

    public function removeBrand(BrandInterface $brand)
    {
        if ($this->brands->contains($brand)) {
            $brand->setModel(null);
            $this->brands->removeElement($brand);
        }
    }

    /**
     * @return string
     */
    public function getProductSlug()
    {
        return $this->translate()->getProductSlug();
    }

    /**
     * @param string $productSlug
     */
    public function setProductSlug($productSlug)
    {
        $this->translate(null, false)->setProductSlug($productSlug);
    }

    /**
     * @return string
     */
    public function getOldProductSlug()
    {
        return $this->oldProductSlug;
    }

    /**
     * @param string $oldProductSlug
     */
    public function setOldProductSlug($oldProductSlug)
    {
        $this->oldProductSlug = $oldProductSlug;
    }

    /**
     * @return mixed
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param mixed $models
     */
    public function setModels($models)
    {
        $this->models = $models;
    }

    /**
     * Set alias.
     *
     * @param string $alias
     *
     * @return Category
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias.
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
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
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Set metaTitle.
     *
     * @param string $metaTitle
     *
     * @return Category
     */
    public function setMetaTitle($metaTitle)
    {
        $this->translate(null, false)->setMetaTitle($metaTitle);

        return $this;
    }

    /**
     * @todo: all meta information must be handle by seo behavior
     * Get metaTitle.
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->translate()->getMetaTitle();
    }

    /**
     * Set metaDescription.
     *
     * @param string $metaDescription
     *
     * @return Category
     */
    public function setMetaDescription($metaDescription)
    {
        $this->translate(null, false)->setMetaDescription($metaDescription);

        return $this;
    }

    /**
     * @todo: all meta information must be handle by seo behavior
     * Get metaDescription.
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->translate()->getMetaDescription();
    }

    /**
     * Add categoria_alert.
     *
     * @param \App\Entity\Alertas $categoria_alert
     *
     * @return Category
     */
    public function addCategoriaAlert(Alertas $categoria_alert)
    {
        $this->categoria_alert[] = $categoria_alert;

        return $this;
    }

    /**
     * Remove categoria_alert.
     *
     * @param \App\Entity\Alertas $categoria_alert
     */
    public function removeCategoriaAlert(Alertas $categoria_alert)
    {
        $this->categoria_alert->removeElement($categoria_alert);
    }

    /**
     * Get categoria_alert.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoriaAlert()
    {
        return $this->categoria_alert;
    }

    public function getIfParent()
    {
        if ($this->hasParent()) {
            return $this->getDirectParent();
        }

        return $this;
    }

    public function hasParent()
    {
        return !is_null($this->parent);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->translate()->getDescription();
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->translate(null, false)->setDescription($description);

        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->translate()->getShortDescription();
    }

    /**
     * @return $this
     */
    public function setShortDescription(string $shortDescription)
    {
        $this->translate(null, false)->setShortDescription($shortDescription);

        return $this;
    }

    public function hasDescriptionInfo()
    {
        $description = $this->getDescription();

        return !empty($description);
    }

    public function setLocale($locale)
    {
        $this->setCurrentLocale($locale);
    }

    public function getLocale()
    {
        return $this->getCurrentLocale();
    }

    public function getContext()
    {
        if (!$this->id) {
            return [];
        }

        if ($this->isRoadBike() || $this->isTriatlonBike() || $this->isCrossBike()) {
            return ContextManager::INCLUDED_ELEMENTS_ROAD_BIKE;
        }

        if ($this->isERoadBike() || $this->isUrbanBike()) {
            return ContextManager::INCLUDED_ELEMENTS_ROAD_EBIKE;
        }

        if ($this->isMountainBike()) {
            return ContextManager::INCLUDED_ELEMENTS_MOUNTAIN_BIKE;
        }

        if ($this->isEMountainBike()) {
            return ContextManager::INCLUDED_ELEMENTS_MOUNTAIN_EBIKE;
        }

        return [];
    }
}
