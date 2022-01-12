<?php

namespace App\Security\Authenticator;

use App\Entity\User;
use App\Event\UserLoggedInViaSocialNetwork;
use App\Event\UserLoggedInViaSocialNetworkEvent;
use App\Service\Factory\UserFactory;
use App\Service\GeneratorPassword\PasswordGenerator;
use App\Service\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\FacebookUser;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FacebookAuthenticator extends SocialAuthenticator
{
    private ClientRegistry $clientRegistry;
    private EntityManagerInterface $em;
    private RouterInterface $router;
    private $session;

    public function __construct(private EventDispatcherInterface $eventDispatcher, private UserServiceInterface $userService, ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router, SessionInterface $session)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
        $this->session = $session;
    }

    public function supports(Request $request)
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return $request->attributes->get('_route') === 'connect_facebook_check';
    }

    public function getCredentials(Request $request)
    {
        // this method is only called if supports() returns true

        // For Symfony lower than 3.4 the supports method need to be called manually here:
        // if (!$this->supports($request)) {
        //     return null;
        // }

        return $this->fetchAccessToken($this->getFacebookClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var FacebookUser $facebookUser */
        $facebookUser = $this->getFacebookClient()
            ->fetchUserFromToken($credentials);

        $email = $facebookUser->getEmail();

        $existingUser = $this->em->getRepository(User::class)
            ->findOneBy(['facebookId' => $facebookUser->getId()]);
        if ($existingUser) {
            return $existingUser;
        }

        // 2) do we have a matching user by email?
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
        if (!$user) {
            $plainPassword = PasswordGenerator::generatePassword();

            $user = UserFactory::createUserFromFacebookUser($facebookUser);
            $user->setPassword($plainPassword);

            $event = new UserLoggedInViaSocialNetworkEvent($user, $plainPassword);

            $this->eventDispatcher->dispatch($event);

            $this->session->getFlashBag()->add('success', 'An email has been sent. Please check your inbox to find password');

             $this->userService->add($user);
        }
        $user->setFacebookId($facebookUser->getId());
        return $user;
    }

    /**
     * @return FacebookClient
     */
    private function getFacebookClient(): FacebookClient
    {
        return $this->clientRegistry
            // "facebook_main" is the key used in config/packages/knpu_oauth2_client.yaml
            ->getClient('facebook_main');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // change "app_homepage" to some route in your app
        $targetUrl = $this->router->generate('main_dashboard');

        return new RedirectResponse($targetUrl);

        // or, on success, let the request continue to be handled by the controller
        //return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent.
     * This redirects to the 'login'.
     */
    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        return new RedirectResponse(
            '/connect/', // might be the site, where users choose their oauth provider
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    // ...
}