<?php

namespace ebeauchamps\MultiTaxonomies\Fieldtypes;

use Statamic\Fields\Fieldtype;
use Illuminate\Support\Str;

class MultiTaxonomiesFieldtype extends Fieldtype
{
    protected $icon = 'tags';
    protected $viewNamespace = 'custom';
    protected $configFields = [
        'information' =>
        [
            'display'       => 'Configuration of type',
            'instructions'  => 'Section where you can configure the type of source of the resources',
            'type'          => 'section',
            'width'         => 100,
            'if'            => [
                'mode'  => 'equals taxonomy',
            ],
        ],
        'mode'      => [
            'display'   => 'select origin',
            'type'      => 'select',
            'instructions'  => 'Select the origin of the resource where the data for the dynamic selects will be obtained',
            'default'   => 'taxonomy',
            'options'   => [
                'taxonomy'  => 'taxonomies',
            ],
            'multiple'  => false,
            'required'  => true,
        ],
        'section_first_taxonomy' =>
        [
            'display'       => 'Config First Taxonomy',
            'instructions'  => 'Section where you configure the data of the first taxonomy',
            'type'          => 'section',
            'width'         => 100,
            'if'            => [
                'mode'  => 'equals taxonomy',
            ],
        ],
        'taxonomies_one'=> [
            'display'   => 'select taxonomy',
            'type'      => 'taxonomies',
            'instructions' => 'Select the first taxonomy',
            'max_items' => 1,
            'if'        => [
                'mode'  => 'equals taxonomy',
            ],
            'required'  => true,
            'width'     => 33
        ],
        'taxonomies_one_field_key' => [
            'display'   => 'Primary key',
            'type'      => 'text',
            'instructions' => 'Write the handle of the column that serves as the primary key',
            'default'   => 'slug',
            'required'  => true,
            'width'     => 33

        ],
        'taxonomies_one_field_label' => [
            'display'   => 'Label column',
            'type'      => 'text',
            'instructions' => 'Write the handle of the column that is the text of the options in the first taxonomy',
            'required'  => true,
            'width'     => 33
        ],
        'section_second_taxonomy' =>
        [
            'display'       => 'Config second Taxonomy',
            'instructions'  => 'Section where you configure the data of the second taxonomy',
            'type'          => 'section',
            'width'         => 100,
            'if'            => [
                'mode'  => 'equals taxonomy',
            ],
        ],
        'taxonomies_depend' => [
            'display'   => 'Second Taxonomy',
            'type'      => 'taxonomies',
            'instructions' => 'Select the dependent taxonomy (second taxonomy)',
            'max_items' => 1,
            'if'        => [
                'mode'  => 'equals taxonomy',
            ],
            'required'  => true,
            'width'     => 25
        ],
        'taxonomies_depend_foreign_key' => [
            'display'       => 'Foreign key',
            'instructions'  => 'Write the name of the main field (primary key) of the taxonomy on which the second taxonomy depends',
            'type'          => 'text',
            'required'      => true,
            'width'         => 25

        ],
        'taxonomies_depend_field_key' => [
            'display'       => 'Primary key',
            'type'          => 'text',
            'instructions'  => 'Write the handle of the column that serves as the primary key',
            'required'      => true,
            'width'         => 25
        ],
        'taxonomies_depend_field_label' => [
            'display'   => 'Label column',
            'type'      => 'text',
            'instructions' => 'Write the handle of the column that is the text of the options in the second taxonomy',
            'required'  => true,
            'width'     => 25
        ],
    ];

    protected function configFieldItems(): array
    {
        return array_map(function ($fieldConfig) {
            if (isset($fieldConfig['instructions'])) {
                $fieldConfig['instructions'] = __('multi-taxonomies::multi-taxonomies.instructions.'.$fieldConfig['instructions']);
            }
            if (isset($fieldConfig['display'])) {
                $fieldConfig['display'] = __('multi-taxonomies::multi-taxonomies.display.'.$fieldConfig['display']);
            }
            return $fieldConfig;
        }, $this->configFields);
    }

    /**
     * Pre-process the data before it gets sent to the publish page.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function preProcess($data)
    {
        $items = [];

        if(is_array($data) || is_object($data))
        {
        foreach($data as $key => $value)
        {
            $items[Str::snake($key)] = $value;
        }
        }

        return $items;
    }

    /**
     * Process the data before it gets saved.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function process($data)
    {
        $items = [];

        if(is_array($data) || is_object($data))
        {
        foreach($data as $key => $value)
        {
            $items[Str::snake($key)] = $value;
        }
        }

        return $items;
    }
}
