<?php

namespace Application\DataFixtures;

use Application\DataFixtures\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        CategoryFactory::new()
            ->createMany(5);
    }
}
