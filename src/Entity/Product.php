<?php

declare(strict_types=1);

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Products')]
class Product
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::STRING, length: 128, unique: true)]
    private string $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255)]
    private string $name;

    /** @var Collection|Category[] */
    #[ORM\ManyToMany(targetEntity: Category::class, cascade: ['persist'])]
    #[ORM\JoinTable(name: 'Products_Categories')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\InverseJoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false)]
    private Collection $categories;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->categories = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /** @return Collection|Category[] */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }
        return $this;
    }
}
