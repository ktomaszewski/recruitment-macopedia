<?php

declare(strict_types=1);

namespace Application\Entity;

use Application\Doctrine\DoctrineType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'Categories')]
class Category
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: DoctrineType::UUID, unique: true)]
    private Uuid $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255)]
    private string $name;

    public function __construct(Uuid $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): Uuid
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
}
