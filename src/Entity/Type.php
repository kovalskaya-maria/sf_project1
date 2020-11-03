<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="type")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

/*
    public function addItems(Item $items): self
    {
        if (!$this->items->contains($items)) {
            $this->items[] = $items;
            $items->setUnivId($this);
        }

        return $this;
    }

    public function removeItems(Item $items): self
    {
        if ($this->items->contains($items)) {
            $this->items->removeElement($items);
            // set the owning side to null (unless already changed)
            if ($items->getTypeID() === $this) {
                $items->setTypeId(null);
            }
        }

        return $this;
    }
*/

/**
 * @return Collection|Item[]
 */
public function getItems(): Collection
{
    return $this->items;
}

public function addItem(Item $item): self
{
    if (!$this->items->contains($item)) {
        $this->items[] = $item;
        $item->setType($this);
    }

    return $this;
}

public function removeItem(Item $item): self
{
    if ($this->items->removeElement($item)) {
        // set the owning side to null (unless already changed)
        if ($item->getType() === $this) {
            $item->setType(null);
        }
    }

    return $this;
}
}
