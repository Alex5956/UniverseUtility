<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;


class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        /** @var \App\Entity\User $user1 */
        $user1=new User();
        $user1->setFirstname('alex22');

        $user1->setEmail("eefeffffffe@fefef.fr");
        $user1->setName("marillesse");
        //$user1->setFile('public/uploads/Fichiers/alexandre-lettremotivation-5f242ed9ef88e.pdf');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setTelephone('050444040');
        $user1->setPassword('coucou');
        $manager->persist($user1);



        $manager->flush();
    }
}
