<?php

declare(strict_types=1);

namespace Application\DataFixtures\Factory;

use Application\Entity\Category;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Category>
 *
 * @method static Category|Proxy createOne(array $attributes = [])
 * @method static Category[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Category|Proxy find(object|array|mixed $criteria)
 * @method static Category|Proxy findOrCreate(array $attributes)
 * @method static Category|Proxy first(string $sortedField = 'id')
 * @method static Category|Proxy last(string $sortedField = 'id')
 * @method static Category|Proxy random(array $attributes = [])
 * @method static Category|Proxy randomOrCreate(array $attributes = [])
 * @method static Category[]|Proxy[] all()
 * @method static Category[]|Proxy[] findBy(array $attributes)
 * @method static Category[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Category[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Category|Proxy create(array|callable $attributes = [])
 */
final class CategoryFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'id'   => Uuid::v4(),
            'name' => self::faker()->slug(3)
        ];
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}
