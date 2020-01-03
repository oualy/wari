<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

public function __construct(UserPasswordEncoderInterface $encoder)
{
    $this->encoder = $encoder;
}

    public function load(ObjectManager $manager)
    {
        $user = new Utilisateur();

        $user->setUsername('adminSys');
        $user->setnom('oualy');
        $user->setprenom('ansou');
        $user->setroles(['ROLE_ADMINSYS']);
        $user->setisActive('true');
         $password = $this->encoder->encodePassword($user, 'pass_1234');
        $user->setPassword($password);
    
        $manager->persist($user);
        $manager->flush();
        
       
    }

}
