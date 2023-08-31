<?php

namespace Aldamr01\Sitemap\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Aldamr01\Sitemap\SitemapServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SitemapServiceProvider::class,
        ];
    }
}
