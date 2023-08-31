<?php

namespace Aldamr01\Sitemap\Contracts;

use Aldamr01\Sitemap\Tags\Url;

interface Sitemapable
{
    public function toSitemapTag(): Url | string | array;
}
