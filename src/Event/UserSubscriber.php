<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegister',
        ];
    }

    public function onUserRegister(UserRegisterEvent $event)
    {
        $body = $this->twig->render('email/registration.html.twig', [
            'user' => $event->getRegistredUser(),
        ]);

        $message = (new \Swift_Message())
            ->setSubject('Welcome to Micro-Post App!')
            ->setFrom('micropost@micropost.com')
            ->setTo($event->getRegistredUser()->getEmail())
            ->setBody($body, 'text/html')
        ;

        $this->mailer->send($message);
    }
}