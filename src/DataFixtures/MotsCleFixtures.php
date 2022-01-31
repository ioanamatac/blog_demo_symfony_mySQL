<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\MotsCle;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class MotsCleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i=1; $i < 20; $i++) {
        $motscle = new MotsCle();
        $article = $this->getReference('article_'.$faker->numberBetween(1,10));                 

         $motscle->setMotCle($faker->text(20));
         $motscle->setSlug($faker->word(60));
         $manager->persist($motscle);          
         $this->addReference('motscle_'.$i, $motscle);            
        }   
        $manager->flush();
    }
    public function getDependencies()
    {
       return [           
           
            ArticleFixtures::class           
       ]; 
    }
}


