<template>
    <f7-page name="types">
        <f7-navbar :title="chaptName" back-link></f7-navbar>

    <!-- <f7-block  v-if="loading" class="row demo-preloaders align-items-stretch text-align-center">
      <f7-col>
        <f7-preloader :size="56" color="#b29a65"></f7-preloader>
      </f7-col>
    </f7-block> -->

    <f7-list media-list v-if="loading" class="margin-t-b-10">
      <f7-list-item 
        v-for="(type) in types"
        :key="type.id"
        title="Lorem ipsum dolor sit amet."
        :link="`#`"
        :class="`skeleton-text skeleton-effect-blink`"
        text=""
        color="red"
      >
        <f7-skeleton-block style="width: 40px; height: 40px; border-radius: 50%" slot="media"></f7-skeleton-block>
      </f7-list-item>
      
    </f7-list>


<f7-list v-else class="margin-t-b-10">
    <template v-for="(type) in types">  
        <f7-list-item
            :key="type.id" 
            :title="type.title"
            :link="`/kinds/${$f7route.params.id}/${type.name}/${type.title}/${type.label}/${chaptName}`"
            

        >
        <div slot="media"><span class="type-label">{{type.label}}</span></div>
        </f7-list-item>
    </template>
</f7-list>
<f7-fab position="right-bottom" slot="fixed" text="" color="#b29a65" >
    <f7-link color="white" icon-ios="f7:arrow_left" icon-aurora="f7:arrow_left" icon-md="material:arrow_back" back></f7-link>
</f7-fab>
    </f7-page>
</template>
<script>
export default {
    data () {

        // code...
        return {
            types: [],
            chaptName: this.$f7route.params.name,
            loading: false

        }
    },
    computed: {
        
    },
    created() {
        
    },
    mounted () {
        var formData = {book: 10, action: 'get_data', tbl: 'types', param: this.$f7route.params.id}
        if (this.loading) return;
        this.loading = true;
        this.$http
            .get('http://conros.cr.local/mobile/backend_mobile_cat.php', {params: formData})
            .then(response => {
                this.types = response.body;
                // this.loading = false;
                this.loading = false;

        });
    }
};
</script>

