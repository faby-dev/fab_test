<?php

namespace App\DataFixtures;

use App\Entity\Etudiants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtudiantsFixtures extends Fixture{
    
    public function load(ObjectManager $manager)
    {
        

        $faker = Factory::create('FR_fr');

        for ($i=0; $i <= 100; $i++) { 
            $Etudiants = new Etudiants();
            $Etudiants->setNom($faker->lastName);
            $Etudiants->setPrenom($faker->firstName);
            $Etudiants->setSexe($faker->randomElement(['male', 'female']));
            $Etudiants->setDateDeNaissance($faker->dateTimeBetween('1981-12-31'));
            $manager->persist($Etudiants);            
        }        
        $manager->flush(); 
    }
}