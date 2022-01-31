<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=1; $i < 30; $i++) {
            $article = new Article();
            $user = $this->getReference('user_'.$faker->numberBetween(1,10));  
            $categorie = $this->getReference('categorie_'.$faker->numberBetween(1,10));          
            $article->setUser($user);        
                      
            $article->setTitre($faker->text(50));            
            $article->setContenu($faker->text(200));
            $article->setSlug($faker->word(60));
            $article->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'));
            $article->setUpdatedAt($faker->dateTimeBetween('-6 month', 'now'));
            $article->setImageArticle("http://placeholder.it/150x150");                   
          
            $manager->persist($article);          
            $this->addReference('article_'. $i, $article);
        }
        $manager->flush();
    }
    public function getDependencies(){

        return [
            CategorieFixtures::class,
            UserFixtures::class
        ];
    }   
    
}
