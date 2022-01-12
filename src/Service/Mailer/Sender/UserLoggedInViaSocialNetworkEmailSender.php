<?php

namespace App\Service\Mailer\Sender;

use App\Entity\User;
use App\Service\Mailer\DTO\MailerOptions;
use App\Service\Mailer\MailerSender;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserLoggedInViaSocialNetworkEmailSender
{

    public function __construct(public MailerSender $mailerSender, public UrlGeneratorInterface $urlGenerator)
    {
    }

    public function sendEmailToClient(User $user, string $plainPassword)
    {
        /* @var MailerOptions */
        $mailerOptions = (new MailerOptions())
            ->setRecipient($user->getEmail())
            ->setFromEmail('robot@realestate.com')
            ->setSubject('RealEstate-board - Your new password')
            ->setHtmlTemplate('main/email/client/user_logged_in_via_social_network.html.twig')
            ->setContext([
                'user' => $user,
                'plainPassword' => $plainPassword,
                'profileUrl' => $this->urlGenerator->generate('main_dashboard', [], UrlGeneratorInterface::ABSOLUTE_URL)
            ]);
        $this->mailerSender->sendTemplatedEmail($mailerOptions);
    }
}