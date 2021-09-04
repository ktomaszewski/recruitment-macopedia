<?php

declare(strict_types=1);

namespace Application\Repository;

use Application\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Uid\Uuid;

final class CategoryRepository
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repository = $this->entityManager->getRepository(Category::class);
    }

    public function findOneById(Uuid $id): ?Category
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository->find($id);
    }

    public function save(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }
}
