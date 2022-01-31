<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Commentaire;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=1; $i < 30; $i++) {
            $commentaire = new Commentaire();
            $article = $this->getReference('article_'.$faker->numberBetween(1,30)); 
            $commentaire->setArticle($article);            
            $commentaire->setContenu($faker->text(200));
            $commentaire->setActif($faker->numberBetween(0, 1));
            $commentaire->setEmail($faker->email);
            $commentaire->setPseudo($faker->word(30));
            $commentaire->setRgpd($faker->numberBetween(0, 1));
            $commentaire->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'));     
       
            $manager->persist($commentaire);
            $this->addReference('commentaire_'. $i, $commentaire);
        }    
        $manager->flush();
    }    
    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
            CategorieFixtures::class
        ]; 
    }
   
}
