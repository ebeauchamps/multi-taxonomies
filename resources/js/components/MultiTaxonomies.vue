<template>
    <div>

        <div
        class="flex-1 flex-no-shrink"
        >
            <label
                :for="selectConfig.taxonomies_one"
                class="publish-field-label mb-1"
            >
                <!-- {{ selectConfig.lb_main_select }} -->
            </label>
            <v-select
                :id="'taxonomy_one'"
                v-model="data.taxonomy_one"
                :options="firstSelectItems"
                :reduce="item => item.key"
                label="label"
                :clearable="true"
                :searchable="true"
                @input="filteredList"
            ></v-select>
        </div>

        <div
        class="flex-1 flex-no-shrink"
        >
            <label
                :for="selectConfig.taxonomies_depend"
                class="publish-field-label mb-1"
            >
                <!-- {{ selectConfig.lb_filter_select }} -->
            </label>
            <v-select
                :id="'taxonomies_depend'"
                v-model="data.taxonomy_depend"
                :options="secondarySelectItemsFiltered"
                :reduce="filter => filter.key"
                label="label"
                :clearable="true"
                :searchable="true"
            ></v-select>
        </div>
    </div>
</template>

<script>
export default {
    mixins: [Fieldtype],
    data: () => ({
        selectConfig: {},
        data : {
            taxonomy_depend : null,
            taxonomy_one : null,
        },
        firstSelectItems: [],
        secondarySelectItems: [],
        secondarySelectItemsFiltered: [],
    }),
    computed: {
        options: () => items,
    },
    watch:
    {
      data:
      {
        deep: true,
        handler: function (newValue, oldValue) {
          this.update(newValue);
        }
      }
    },
    methods: {
        mainConfig()
        {
            var self = this;
            self.selectConfig = self.config;
            self.data['taxonomy_one']   = null;
        },
        mainData()
        {
            var self = this;

            const url = cp_url('ebeauchamps/multitaxonomies/getFirstSelectItems');

            self.$axios
            .post(url, self.selectConfig)
            .then(items =>
            {
                self.firstSelectItems = items.data.firstTerms
                self.secondarySelectItems = items.data.depentTerm

                if(self.value['taxonomy_one'])
                {
                 self.filteredList(self.value['taxonomy_one']);
                 self.data['taxonomy_one'] = self.value['taxonomy_one'];
                 self.data['taxonomy_depend'] = self.value['taxonomy_depend'];
                }
            })
            .catch(error =>
            {
                console.log(error);
            });
        },
        filteredList(option)
        {
            var self = this;
            self.data.taxonomy_depend = null
            self.secondarySelectItemsFiltered   = [];
            self.secondarySelectItemsFiltered   = self.secondarySelectItems.filter(opc => opc.foreign == option);
        }
    },
    mounted()
    {
      var self = this;
      self.mainConfig();
      self.mainData();
    }
};
</script>
