<?php
namespace Tresdstudioweb\DynamicSelect\Tests\Unit;

use Statamic\Facades\Taxonomy;
use Statamic\Contracts\Taxonomies\TaxonomyRepository;
use Tresdstudioweb\DynamicSelect\Tests\TestCase;
use Statamic\Taxonomies\Term;
use Statamic\Facades\Term as FacadeTerms;
use Illuminate\Support\Facades\Artisan;

use function Pest\Laravel\{actingAs, get, post};
use function Pest\Livewire\livewire;

beforeEach(function () {
    /** Create blueprint Taxonomie Depto */
    $blueprintYAML = "  - handle: title\n";
    $blueprintYAML .= "    field:\n";
    $blueprintYAML .= "      type: text\n";
    $blueprintYAML .= "      display: Title \n";
    $blueprintYAML .= "  - handle: slug\n";
    $blueprintYAML .= "    field:\n";
    $blueprintYAML .= "      type: text\n";
    $blueprintYAML .= "      display: Id or slug 2\n";
    $blueprintYAML .= "  - handle: label\n";
    $blueprintYAML .= "    field:\n";
    $blueprintYAML .= "      type: text\n";
    $blueprintYAML .= "      display: Label 3\n";

    $firstTaxonomie = $this->makeTaxonomieBlueprintForFileYaml($blueprintYAML, 'depto','/__fixtures__/content/taxonomies/' );

    /** Create terms for first taxonomy */
    FacadeTerms::make()
        ->taxonomy($firstTaxonomie)
        ->data(['title' => 'bogota', 'label' => 'Bogotá'])
        ->slug('bogota')
        ->save();

    FacadeTerms::make()
        ->taxonomy($firstTaxonomie)
        ->data(['title' => 'valle del cauca', 'label' => 'Valle del Cuaca'])
        ->slug('valle-del-cauca')
        ->save();

    FacadeTerms::make()
        ->taxonomy($firstTaxonomie)
        ->data(['title' => 'cundinamarca', 'label' => 'Cundinamarca'])
        ->slug('valle-del-cauca')
        ->save();

    /** Create blueprint Taxonomie city */
    $blueprintYAML = "  - handle: title\n";
    $blueprintYAML .= "    field:\n";
    $blueprintYAML .= "      type: text\n";
    $blueprintYAML .= "      display: Title\n";
    $blueprintYAML .= "  - handle: foring-key\n";
    $blueprintYAML .= "    field:\n";
    $blueprintYAML .= "      type: text\n";
    $blueprintYAML .= "      display: Foreing Key\n";
    $blueprintYAML .= "  - handle: label\n";
    $blueprintYAML .= "    field:\n";
    $blueprintYAML .= "      type: text\n";
    $blueprintYAML .= "      display: Label\n";

    $secondTaxonomie = $this->makeTaxonomieBlueprintForFileYaml($blueprintYAML, 'city','/__fixtures__/content/taxonomies/' );

    /** Create terms for second taxonomy */
    FacadeTerms::make()
        ->taxonomy($secondTaxonomie)
        ->data(['title' => 'bogota', 'foringkey' => 'bogota', 'label' => 'Bogotá'])
        ->slug('bogota')
        ->save();

    FacadeTerms::make()
        ->taxonomy($secondTaxonomie)
        ->data(['title' => 'cali', 'foringkey' => 'valle-del-cauca', 'label' => 'Cali'])
        ->slug('cali')
        ->save();

    FacadeTerms::make()
        ->taxonomy($secondTaxonomie)
        ->data(['title' => 'ricuarte', 'foringkey' => 'cundinamarca', 'label' => 'Ricuarte'])
        ->slug('ricuarte')
        ->save();

    FacadeTerms::make()
        ->taxonomy($secondTaxonomie)
        ->data(['title' => 'agua de dios', 'foringkey' => 'cundinamarca', 'label' => 'Agua de Dios'])
        ->slug('aguadedios')
        ->save();

});

it('get elements for taxonomies', function(){
    post(route('statamic.tresdstudioweb.dynamicselect.getFirstSelectItems', [
            "mode" => "taxonomy",
            "taxonomies_one" => "depto",
            "taxonomies_depend" => "city",
            "foreing_key" => "depto",
            "taxonomies_one_field_key" => "slug",
            "taxonomies_one_field_label" => "label",
            "taxonomies_depend_foreing_key" => "foring-key",
            "taxonomies_depend_field_key" => "slug",
            "taxonomies_depend_field_label" => "label",
    ]))->assertStatus(200);
});

