<?php

declare(strict_types=1);

namespace Application\Repository;

use Application\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class ProductRepository
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repository = $this->entityManager->getRepository(Product::class);
    }

    public function findOneById(string $id): ?Product
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository->find($id);
    }

    public function save(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}
