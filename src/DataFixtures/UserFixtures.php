<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Faker;


class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        
        $faker = Faker\Factory::create('fr_FR');

        for($nbUsers = 1; $nbUsers <= 30; $nbUsers++){
                      
            $user = new User();
            $user->setEmail($faker->email);

            if($nbUsers === 1)
                $user->setRoles(['ROLE_ADMIN']);
            else
                $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->encoder->encodePassword($user, '123456'));
            
            $manager->persist($user);
            // Enregistre l'utilisateur dans une référence
            $this->addReference('user_'.$nbUsers, $user);            
        }

        $manager->flush();
    }
}


    

