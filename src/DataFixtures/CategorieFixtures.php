<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            1 => [
                'nom' => 'Politique',
                'slug'=> 'Slug categorie'
            ],
            2 => [
                'nom' => 'Economie',
                'slug'=> 'Slug categorie'
            ],
            3 => [
                'nom' => 'Culture',
                'slug'=> 'Slug categorie'
            ],
            4 => [
                'nom' => 'Débats',
                'slug'=> 'Slug categorie'
            ],
            5 => [
                'nom' => 'Savoir Vivre',
                'slug'=> 'Slug categorie'
            ],
            6 => [
                'nom' => 'Vidéos',
                'slug'=> 'Slug categorie'
            ],
            7 => [
                'nom' => 'Planète',
                'slug'=> 'Slug categorie'
            ],
            8 => [
                'nom' => 'International',
                'slug'=> 'Slug categorie'
            ],
            9 => [
                'nom' => 'Santé',
                'slug'=> 'Slug categorie'
            ],
            10 => [
                'nom' => 'Sciences',
                'slug'=> 'Slug categorie'
            ],
            10 => [
                'nom' => 'Les décodeurs',
                'slug'=> 'Slug categorie'
            ],
            11 => [
                'nom' => 'Sport',
                'slug'=> 'Slug categorie'
            ],

        ];
        foreach($categories as $key => $value){
           $categorie = new Categorie(); 
           $categorie->setNom($value['nom']);
           $categorie->setSlug($value['slug']);
           $manager->persist($categorie);

           // Enregistrer la categorie dans une référence
           $this->addReference('categorie_'. $key, $categorie); 
        }
        
        $manager->flush();
    }
}


