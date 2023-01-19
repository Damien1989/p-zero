<?php
namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $program = new Program();
        $program->setTitle('Super Mario');
        $program->setSynopsis("A man who sold the world");
        $program->setPoster('hello');
        $program->setCategory($this->getReference('category_Action'));
        $manager->persist($program);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,

        ];

    }
}



