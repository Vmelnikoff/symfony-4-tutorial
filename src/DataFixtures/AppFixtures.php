<?php


namespace App\DataFixtures;


use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadMicroposts($manager);
        $this->loadUsers($manager);
    }

    private function loadMicroposts(ObjectManager $manager): void
    {
        for ($i = 1; $i < 10; $i++) {
            $microPost = new MicroPost();
            $microPost->setText('Some random text - ' . rand(1, 100));
            $microPost->setTime(new \DateTime('2018-03-15'));
            $manager->persist($microPost);
        }
        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('john_doe');
        $user->setFullName('John Doe');
        $user->setEmail('john_doe@doe.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'john123'));

        $manager->persist($user);
        $manager->flush();
    }
}