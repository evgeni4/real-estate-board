<?php

namespace App\Service\Seo;

use App\Service\Admin\Settings\SettingsServiceInterface;
use Sonata\SeoBundle\Seo\SeoPageInterface;

class SeoService implements SeoServiceInterface
{

    public function __construct(
        public SettingsServiceInterface $settingsService,
        public SeoPageInterface         $seo
    )
    {

    }

    public function seo(string $pageTitle , string $keywords = null, string $description = null, string $ogTitle = null, string $ogDescription = null, string $ogSiteName = null): void
    {

         $this->seo->setTitle($pageTitle)
            ->addMeta('name', 'keywords', $keywords)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $ogTitle)
            ->addMeta('property', 'og:description', $ogDescription)
            ->addMeta('property', 'og:site_name', $ogSiteName);
    }

    public function seoProperty($param, string $locale = null)
    {
        $settings = $this->settingsService->findOneRecord();
        $this->seo->setTitle($param->translate($locale)->getTitle())
            ->addMeta('name', 'keywords', $param->translate($locale)->getKeywords())
            ->addMeta('name', 'description', substr($param->translate($locale)->getDescription(),0,100))
            ->addMeta('property', 'og:title', $param->translate($locale)->getTitle())
            ->addMeta('property', 'og:description', substr($param->translate($locale)->getDescription(),0,100))
            ->addMeta('property', 'og:site_name', $settings->translate($locale)->getSiteName());
    }
}