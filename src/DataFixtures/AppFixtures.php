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
        $projects = [];

        for ($i=0; $i < 5; $i++) { 
            $user = (new User())
            ->setEmail($faker->email())
            ->setPassword('password')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName());
            
            $manager->persist($user);
            $users[] = $user;
            
        }

        // foreach ($users as $user) {
        //     for ($i=0; $i < rand(2, 8); $i++) { 
        //         $task = (new Tasks())
        //                 ->setName($faker->realTextBetween(15, 40))
        //                 ->setDescription($faker->realTextBetween(30, 150))
        //                 ->setStatus('encours')
        //                 ->setOwner($user);

        //             $manager->persist($task);
        //     }
        // }


        for ($i=0; $i < 5; $i++) { 
            $project = (new Projects())
                ->setName($faker->text(10,30))
                ->setDescription($faker->realTextBetween(20, 150))
                ->setStatus('encours')
                ->setDeadline(new DateTimeImmutable('+10days'));

            $manager->persist($project);
            $projects[]=$project;
            }
        
            foreach ($projects as $project) {
                for($i=0; $i < rand(1,6); $i++) { 
                    $contributor = $users[rand(0,4)];
                    $project->addContributor($contributor);
                    for ($a=0; $a < 3 ; $a++) { 
                        $task = (new Tasks())
                            ->setName($faker->realTextBetween(15, 40))
                            ->setDescription($faker->realTextBetween(30, 150))
                            ->setStatus('encours')
                            ->setOwner($contributor);
                        $manager->persist($task);
                        $project->addTask($task);
                    }
                }
            }
            

        $manager->flush();
    }
}
