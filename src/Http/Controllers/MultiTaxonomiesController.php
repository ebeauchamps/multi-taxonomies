<?php

namespace ebeauchamps\MultiTaxonomies\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Facades\Term;
use Statamic\Http\Controllers\CP\CpController;

class MultiTaxonomiesController extends CpController
{
    public function getFirstSelectItems(Request $request)
    {
        $answer = null;
        $firstTerm = null;
        $depentTerm = null;
        switch ($request->mode) {
            case 'taxonomy':
                $firstTerm = $this->getTermsTaxonomy($request->taxonomies_one, $request);
                $depentTerm = $this->getTermsTaxonomyDepend($request->taxonomies_depend, $request);
                break;

            default:

                break;
        }
        $answer['firstTerms'] = $firstTerm;
        $answer['depentTerm'] = $depentTerm;
        return $answer;
    }

    public function getTermsTaxonomy($handleTaxonomy, $config, $typeTaxonomy = 'principal')
    {
        $terms  = null;
        $terms = Term::whereTaxonomy($handleTaxonomy)->sortBy($config->taxonomies_one_field_label)->pluck( $config->taxonomies_one_field_label,$config->taxonomies_one_field_key);
        $collectTerms = collect();
        foreach($terms as $key => $term){
            $collectTerms->push([
                'key'   => $key,
                'label' => $term
            ]);
        }
        return $collectTerms;
    }

    public function getTermsTaxonomyDepend($handleTaxonomy, $config)
    {
        $terms = Term::whereTaxonomy($handleTaxonomy)->sortBy($config->taxonomies_one_field_label);
        $collectTerms = collect();
        foreach($terms as $key => $term){
            $collectTerms->push([
                'key'   => $term->{$config->taxonomies_depend_field_key},
                'foreign' => $term->{$config->taxonomies_depend_foreign_key},
                'label' => $term->{$config->taxonomies_depend_field_label}
            ]);
        }
        return $collectTerms;
    }
}
