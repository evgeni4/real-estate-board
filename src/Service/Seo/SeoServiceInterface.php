<?php

namespace App\Service\Seo;

interface SeoServiceInterface
{
    public function seo(string $pageTitle , string $keywords = null, string $description = null, string $ogTitle = null, string $ogDescription = null, string $ogSiteName = null);
    public function seoProperty($param ,string $locale = null);


}