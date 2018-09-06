<?php

namespace App\Tests\Mailer;

use App\Entity\User;
use App\Mailer\Mailer;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension;

class MailerTest extends TestCase
{
    public function testConfirmationEmail(): void
    {
        $user = new User();
        $user->setEmail('john@doe.com');

//        $swiftMailer = $this->createMock(\Swift_Mailer::class);
        $swiftMailer = $this->getMockBuilder(\Swift_Mailer::class)
                            ->disableOriginalConstructor()
                            ->getMock()
        ;
//        $twig = $this->createMock(\Twig_Environment::class);
        $twig = $this->getMockBuilder(\Twig_Environment::class)
                            ->disableOriginalConstructor()
                            ->getMock()
        ;

        $mailer = new Mailer($swiftMailer, $twig, 'me@domain.com');
        $mailer->sendConfirmationEmail($user);
    }

}
