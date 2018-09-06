<?php

namespace App\Tests\Mailer;

use App\Entity\User;
use App\Mailer\Mailer;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

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
        $swiftMailer->expects($this->once())
                    ->method('send')
                    ->with($this->callback(function ($subject) {
                        $messageStr = (string)$subject;
//            /** @var \Swift_Message $messageStr */
//            $messageStr = $subject;
//            dump($messageStr->toString());
//            dump($messageStr);

                        return strpos($messageStr, 'Subject: Welcome to Micro-Post App!') !== false
                            && strpos($messageStr, 'From: me@domain.com') !== false
                            && strpos($messageStr, 'To: john@doe.com') !== false
                            && strpos($messageStr, 'Content-Type: text/html; charset=utf-8') !== false
                            && strpos($messageStr, 'This is message string') !== false
                            ;
                    }))
        ;

//        $twig = $this->createMock(\Twig_Environment::class);
        $twig = $this->getMockBuilder(\Twig_Environment::class)
                     ->disableOriginalConstructor()
                     ->getMock()
        ;
        $twig->expects($this->once())
             ->method('render')
             ->with('email/registration.html.twig',
                 [
                     'user' => $user,
                 ])
            ->willReturn('This is message string')
        ;

        $mailer = new Mailer($swiftMailer, $twig, 'me@domain.com');
        $mailer->sendConfirmationEmail($user);
    }
}
