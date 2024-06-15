<?php

namespace ebeauchamps\MultiTaxonomies;

use Statamic\Providers\AddonServiceProvider;
use ebeauchamps\MultiTaxonomies\Fieldtypes\MultiTaxonomiesFieldtype;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        // 'cp' => $this->basePath('routes/cp.php'),
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    protected $fieldtypes = [
        MultiTaxonomiesFieldtype::class,
    ];

    protected $vite = [
        'input' => [
            'resources/js/addon.js',
        ],
        'publicDirectory' => 'dist/js',
    ];


    public function bootAddon()
    {
        MultiTaxonomiesFieldtype::register();
    }

    public function bootPublishables() : self
    {
        $this->loadTranslationsFrom(
            $this->basePath('resources/lang'),
            'multi-taxonomies'
        );

        $this->publishes([
            $this->basePath('resources/lang') => resource_path('lang/vendor/multi-taxonomies ')
        ], 'multi-taxonomies-translations');

        return $this;
    }

    public function basePath($path = '')
    {
        return __DIR__.'/../'.$path;
    }

}
