import MultiTaxonomies from './components/MultiTaxonomies.vue'

Statamic.booting(() => {
    Statamic.$components.register('multi_taxonomies-fieldtype', MultiTaxonomies);
});
