<?php

namespace App\Menu\UserMenu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    /**
     * @param FactoryInterface $factory
     */
    public function __construct(public FactoryInterface $factory)
    {
    }
    public function userSmallMenu(RequestStack $requestStack): ItemInterface
    {
        $smallMenu = $this->factory->createItem('root');
         $smallMenu->addChild('Dashboard', ['route' => 'main_dashboard'])
            ->setExtra('icon', 'fal fa-chart-line');
//        Dashboard
         $smallMenu->addChild('add.listing.label', ['uri' => '#'])
            ->setExtra('icon', 'fal fa-file-plus');
//        add.listing.label
//         $smallMenu->addChild('settings.label', ['uri' => '#'])
//            ->setExtra('icon', 'fal fa-user-edit');
//         settings.label
        return $smallMenu;
    }
    public function userMenu(RequestStack $requestStack): ItemInterface
    {
        $userMenu = $this->factory->createItem('root');
        $userMenu->setChildrenAttributes(array('class' => 'no-list-style'));
         $userMenu->addChild('Dashboard', ['route' => 'main_dashboard'])
            ->setExtra('icon', 'fal fa-chart-line');
//        Dashboard
        $userMenu->addChild('listings.label', ['uri' => '#'])
            ->setExtra('icon', 'fal fa-plus')
            ->setAttributes(['class'=>''])
            ->setLinkAttribute('class', 'submenu-link')
            ->setChildrenAttribute('class','nav-group-items');
             $userMenu['listings.label']->addChild('all.properties.label', ['route' => 'main_dashboard'])
              ->setExtra('icon', 'fal fa-th-list');
             $userMenu['listings.label']->addChild('bookings.label', ['route' => 'main_dashboard'])
              ->setExtra('icon', 'fal fa-calendar-check')
              ->setExtra('count', '34');
             $userMenu['listings.label']->addChild('reviews.label', ['route' => 'main_dashboard'])
              ->setExtra('icon', 'fal fa-comments-alt');
             $userMenu['listings.label']->addChild('add.listing.label', ['route' => 'main_dashboard'])
              ->setExtra('icon', 'fal fa-file-plus');
//        listings.label
        $userMenu->addChild('settings.label', ['uri' => '#'])
            ->setExtra('icon', 'fal fa-plus')
            ->setAttributes(['class'=>''])
            ->setLinkAttribute('class', 'submenu-link')
            ->setChildrenAttribute('class','nav-group-items');
         $userMenu['settings.label']->addChild('edit.profile.label', ['uri' => '#'])
            ->setExtra('icon', 'fal fa-user-edit');
//        Edit profile
         $userMenu->addChild('messages.label', ['uri' => '#'])
            ->setExtra('icon', 'fal fa-envelope')->setExtra('count', '5');
//        Messages
         $userMenu->addChild('agents.list.label', ['uri' => '#'])
            ->setExtra('icon', 'fal fa-users');
//        Messages
        $userMenu->addChild('Submenu', ['uri' => '#'])
        ->setExtra('icon', 'fal fa-plus')
        ->setAttributes(['class'=>''])
        ->setLinkAttribute('class', 'submenu-link')
        ->setChildrenAttribute('class','nav-group-items');
        $userMenu['Submenu']->addChild('Submenu 2', ['uri' => '#'])
            ->setExtra('icon', 'fal fa-th-list')
            ->setAttributes(['class', 'nav-item'])
            ->setLinkAttribute('class', 'nav-link');
//      Submenu

        return $userMenu;
    }
}