<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=500)
     */
    private $minSurface;

    /**
     * @var ArrayCollection
     */
    private $propertyOptions;

    public function __construct()
    {
        $this->propertyOptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    public function setMinSurface(int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPropertyOptions(): ArrayCollection
    {
        return $this->propertyOptions;
    }

    /**
     * @param ArrayCollection $propertyOptions
     */
    public function setPropertyOptions(ArrayCollection $propertyOptions): void
    {
        $this->propertyOptions = $propertyOptions;
    }
}
