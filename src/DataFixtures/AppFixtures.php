<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Tasks;
use DateTimeImmutable;
use App\Entity\Projects;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker= Factory::create();

        $users = [];

        for ($i=0; $i < 5; $i++) { 
            $user = (new User())
            ->setEmail($faker->email())
            ->setPassword('password')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName());
            
            $manager->persist($user);
            $users[] = $user;
            
        }

        foreach ($users as $user) {
            for ($i=0; $i < rand(2, 8); $i++) { 
                $task = (new Tasks())
                        ->setName($faker->realTextBetween(20, 80))
                        ->setDescription($faker->realTextBetween(50, 250))
                        ->setStatus('encours')
                        ->setOwner($user);

                    $manager->persist($task);
            }
        }


        for ($i=0; $i < 5; $i++) { 
            $project = (new Projects())
                ->setName($faker->text(20, 50))
                ->setDescription($faker->realTextBetween(20, 250))
                ->setStatus('encours')
                ->setDeadline(new DateTimeImmutable('+10days'));
            
            for($i=0; $i < rand(1,4); $i++) { 
                $contributor = $users[rand(0,4)];
                $project->addContributor($contributor);
                for ($a=0; $a < rand(2,6) ; $a++) { 
                    $task = (new Tasks())
                        ->setName($faker->realTextBetween(20, 80))
                        ->setDescription($faker->realTextBetween(50, 250))
                        ->setStatus('encours')
                        ->setOwner($contributor);
                    $manager->persist($task);
                    $project->addTask($task);
                }
            }

            $manager->persist($project);
            }

        $manager->flush();
    }
}
