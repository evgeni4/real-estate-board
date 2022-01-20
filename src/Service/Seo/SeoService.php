<?php

namespace App\Service\Seo;

use Sonata\SeoBundle\Seo\SeoPageInterface;

class SeoService implements SeoServiceInterface
{

    public function __construct(public SeoPageInterface $seo)
    {

    }

    public function seo(string $pageTitle=null, string $keywords=null, string $description=null, string $ogTitle = null, string $ogDescription = null, string $ogSiteName = null)
    {
        $this->seo->setTitle($pageTitle)
            ->addMeta('name', 'keywords', $keywords)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $ogTitle)
            ->addMeta('property', 'og:description', $ogDescription)
            ->addMeta('property', 'og:site_name', $ogSiteName);
    }
}