<?php

namespace App\DataFixtures;

use App\Entity\Lecon;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LeconFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("fr_FR");

        $user = new User();
        $user->setUsername('admin')
            ->setPassword($this->passwordHasher->hashPassword($user, 'secret'))
            ->setPrenom('Luffy')
            ->setNom('Monkey D')
            ->setRoles(['ROLE_PROFESSEUR', 'ROLE_ADMIN']);
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {

            $lecon = new Lecon();
            $lecon->setNom($faker->word)
                ->setDescription("**Principe de la Leçon :** " . $faker->paragraph)
                ->setProfesseur($user);
            $manager->persist($lecon);

        }

        $user = new User();
        $user->setUsername('naruto')
            ->setPassword($this->passwordHasher->hashPassword($user, 'secret'))
            ->setPrenom('Naruto')
            ->setNom('Uzumaki')
            ->setRoles(['ROLE_PROFESSEUR']);
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {

            $lecon = new Lecon();
            $lecon->setNom($faker->word)
                ->setDescription("**Principe de la Leçon :** " . $faker->paragraph)
                ->setProfesseur($user);
            $manager->persist($lecon);

        }

        $user = new User();
        $user->setUsername('jotaro')
            ->setPassword($this->passwordHasher->hashPassword($user, 'secret'))
            ->setPrenom('Jotaro')
            ->setNom('Kujo')
            ->setRoles(['ROLE_ELEVE']);
        $manager->persist($user);

        $manager->flush();

    }

}
