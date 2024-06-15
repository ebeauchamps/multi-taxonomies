<?php

namespace Tresdstudioweb\DynamicSelect\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;
use Tresdstudioweb\DynamicSelect\ServiceProvider;
use Statamic\Facades\Entry;
use Statamic\Facades\Collection;
use Statamic\Facades\Taxonomy;
use Statamic\Facades\User;
use Statamic\Extend\Manifest;
use Illuminate\Foundation\Testing\WithFaker;
use Statamic\Fields\Blueprint;
use Statamic\Taxonomies\Taxonomy as TaxonomiesTaxonomy;
use Statamic\Fields\Field;
use Statamic\Facades\FieldFacades;
use Statamic\Fields\Fieldtype;

abstract class TestCase extends OrchestraTestCase
{
    use WithFaker;

    protected function getPackageProviders($app)
    {
        return [
            StatamicServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'Tresdstudioweb\DynamicSelect' => [
                'id' => 'Tresdstudioweb\DynamicSelect',
                'namespace' => 'Tresdstudioweb\\DynamicSelect\\',
            ],
        ];

        Statamic::pushActionRoutes(function() {
            return require_once realpath(__DIR__.'/../routes/cp.php');
        });
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $configs = [
            'assets', 'cp', 'forms', 'static_caching',
            'sites', 'stache', 'system', 'users'
        ];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require(__DIR__."/../vendor/statamic/cms/config/{$config}.php"));
        }

        $app['config']->set('statamic.users.repository', 'file');
        $app['config']->set('statamic.stache', require(__DIR__.'/__fixtures__/config/statamic/stache.php'));
    }

    protected function makeUser()
    {
        return User::make()
            ->id((new \Statamic\Stache\Stache())->generateId())
            ->email($this->faker->email)
            ->save();
    }

    protected function makeCollection(string $handle, string $name)
    {
        Collection::make($handle)
            ->title($name)
            ->pastDateBehavior('public')
            ->futureDateBehavior('private')
            ->save();

        return Collection::findByHandle($handle);
    }

    protected function makeEntry(string $collectionHandle)
    {
        $slug = $this->faker->slug;

        Entry::make()
            ->collection($collectionHandle)
            ->blueprint('default')
            ->locale('default')
            ->published(true)
            ->slug($slug)
            ->data([
                'likes' => [],
            ])
            ->set('updated_by', User::all()->first()->id())
            ->set('updated_at', now()->timestamp)
            ->save();

        return Entry::findBySlug($slug, $collectionHandle);
    }

    protected function makeTaxonomy(string $taxonomy, string $name)
    {

        $blueprintYAML = "title: Mi Blueprint\nfields:\n";
        $blueprintYAML .= "  - handle: campo1\n";
        $blueprintYAML .= "    field:\n";
        $blueprintYAML .= "      type: text\n";
        $blueprintYAML .= "      display: Campo 1\n";
        $blueprintYAML .= "  - handle: campo2\n";
        $blueprintYAML .= "    field:\n";
        $blueprintYAML .= "      type: text\n";
        $blueprintYAML .= "      display: Campo 2\n";
        $blueprintYAML .= "  - handle: campo3\n";
        $blueprintYAML .= "    field:\n";
        $blueprintYAML .= "      type: text\n";
        $blueprintYAML .= "      display: Campo 3\n";

        file_put_contents(__DIR__.'/__fixtures__/content/taxonomies/'.$taxonomy.'.yaml', $blueprintYAML);

        return Taxonomy::findByHandle($taxonomy);
        // return $taxonomy;
    }

    protected function makeTaxonomieBlueprintForFileYaml(string $blueprintYAMLContent, string $name, $ruta)
    {
        $blueprintYAMLContent = "title: $name\nfields:\n".$blueprintYAMLContent;

        file_put_contents(__DIR__."$ruta$name.yaml", $blueprintYAMLContent);

        return Taxonomy::findByHandle($name);
    }
}
