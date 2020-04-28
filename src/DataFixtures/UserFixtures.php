<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    private $objectManager;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $objectManager)
    {

        $this->objectManager = $objectManager;

        $user = new User();
        $user->setEmail('nikolaev.dolg@yandex.ru');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'password1946'
            )
        );
        $this->objectManager->persist($user);


        $user = new User();
        $user->setEmail('uk.i.c.k.e.ru@yandex.ru');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'mynewpassword1946'
            )
        );
        $this->objectManager->persist($user);


        $user = new User();
        $user->setEmail('uk.i.s.k.e.ru@yandex.ru');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'mynewpassword'
            )
        );
        $this->objectManager->persist($user);


        $this->objectManager->flush();

    }
}
