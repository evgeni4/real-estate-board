<?php

namespace App\Menu\UserMenu;

use App\Service\User\UserServiceInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class Builder
{
    /**
     * @param FactoryInterface $factory
     * @param UserServiceInterface $userService
     */
    public function __construct(public FactoryInterface $factory, public UserServiceInterface $userService)
    {
    }
    public function userSmallMenu(RequestStack $requestStack): ItemInterface
    {
        $smallMenu = $this->factory->createItem('root');
         $smallMenu->addChild('Dashboard', ['route' => 'main_dashboard'])
            ->setExtra('icon', 'fal fa-chart-line');
//        Dashboard
//         $smallMenu->addChild('add.listing.label', ['uri' => '#'])
//            ->setExtra('icon', 'fal fa-file-plus');
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
             $userMenu['listings.label']->addChild('all.properties.label', ['route' => 'main_show_listing'])
              ->setExtra('icon', 'fal fa-th-list');
//             $userMenu['listings.label']->addChild('bookings.label', ['route' => 'main_dashboard'])
//              ->setExtra('icon', 'fal fa-calendar-check')
//              ->setExtra('count', '34');
             $userMenu['listings.label']->addChild('add.listing.label', ['route' => 'main_add_listing'])
              ->setExtra('icon', 'fal fa-file-plus');
//        listings.label
        $userMenu->addChild('settings.label', ['uri' => '#'])
            ->setExtra('icon', 'fal fa-plus')
            ->setAttributes(['class'=>''])
            ->setLinkAttribute('class', 'submenu-link')
            ->setChildrenAttribute('class','nav-group-items');
         $userMenu['settings.label']->addChild('edit.profile.label', ['route' => 'main_profile'])
            ->setExtra('icon', 'fal fa-user-edit');
        $userMenu['settings.label']->addChild('view.profile.label', ['route' => 'main_profile_show','routeParameters'=>['uuid'=>$this->userService->currentUser()->getUuid()]])
            ->setExtra('icon', 'fas fa-eye')
            ->setLinkAttributes(array('target' => '_blank'));
//        Edit profile
         $userMenu->addChild('messages.label', ['route' => 'main_messages'])
            ->setExtra('icon', 'fal fa-envelope')->setExtra('count', '5');
//        Messages
//        reviews

        $userMenu->addChild('reviews.label', ['route' => 'main_reviews_show'])
            ->setExtra('icon', 'fal fa-comments-alt');
//        reviews
//         $userMenu->addChild('agents.list.label', ['uri' => '#'])
//            ->setExtra('icon', 'fal fa-users');
//        Messages
//        $userMenu->addChild('Submenu', ['uri' => '#'])
//        ->setExtra('icon', 'fal fa-plus')
//        ->setAttributes(['class'=>''])
//        ->setLinkAttribute('class', 'submenu-link')
//        ->setChildrenAttribute('class','nav-group-items');
//        $userMenu['Submenu']->addChild('Submenu 2', ['uri' => '#'])
//            ->setExtra('icon', 'fal fa-th-list')
//            ->setAttributes(['class', 'nav-item'])
//            ->setLinkAttribute('class', 'nav-link')
        ;
//      Submenu
        return $userMenu;
    }
    public function adminMenu(RequestStack $requestStack): \Knp\Menu\ItemInterface
    {
        $adminMenu = $this->factory->createItem('root');
        $adminMenu->setChildrenAttributes(array('class' => 'metismenu list-unstyled', 'id' => 'side-menu'));
        $adminMenu->addChild('view.site.label', ['route' => 'app_home'])
            ->setExtra('icon', 'bx bx-link-external')
            ->setLinkAttributes(array('target' => '_blank'));

        $adminMenu->addChild('Dashboard', ['route' => 'admin_dashboard'])
            ->setExtra('icon', 'bx bx-home-circle');

        $adminMenu->addChild('catalog.label', ['uri' => '#'])
            ->setLinkAttribute('class', 'has-arrow waves-effect')
            ->setExtra('icon', 'fa fa-tags');

        $adminMenu['catalog.label']->addChild('properties.label', ['uri' => '#'])
            ->setExtra('icon', 'fa fa-arrow-right');

        $adminMenu['catalog.label']->addChild('categories.label', ['route' => 'admin_category_show'])
            ->setExtra('icon', 'fa fa-arrow-right');

        $adminMenu['catalog.label']->addChild('type.label', ['uri' => '#'])
            ->setLinkAttribute('class', 'has-arrow waves-effect')
            ->setExtra('icon', 'fa fa-tags');

        $adminMenu['catalog.label']['type.label']->addChild('type.all.label', ['route' => 'admin_type_show'])
            ->setExtra('icon', 'fa fa-arrow-right');

        $adminMenu['catalog.label']['type.label']->addChild('period.label', ['route' => 'admin_type_period_show'])
            ->setExtra('icon', 'fa fa-arrow-right');

        $adminMenu['catalog.label']->addChild('amenities.label', ['route' => 'admin_amenities_show'])
            ->setExtra('icon', 'fa fa-arrow-right');



        $adminMenu->addChild( 'system.label', ['uri' => '#'])
            ->setLinkAttribute('class', 'has-arrow waves-effect')
            ->setExtra('icon', 'fa fa-cog');

        $adminMenu['system.label']->addChild('settings.label', ['route' => 'admin_settings_show'])
            ->setExtra('icon', 'fa fa-arrow-right');

        $adminMenu->addChild('logout.label', ['route' => 'admin_security_logout'])
            ->setExtra('icon', 'bx bx-power-off text-danger');
        return $adminMenu;
    }

}