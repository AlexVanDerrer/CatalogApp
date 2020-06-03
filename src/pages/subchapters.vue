<template>
    <f7-page name="subchapters">
        <f7-navbar :title="chaptName" back-link></f7-navbar>


    <!-- <f7-block  v-if="loading" class="row demo-preloaders align-items-stretch text-align-center">
      <f7-col>
        <f7-preloader :size="56" color="#b29a65"></f7-preloader>
      </f7-col>
    </f7-block> -->

    <f7-list media-list v-if="loading"  class="margin-t-b-10">
      <f7-list-item
        v-for="(chapt) in chapters"
        :key="chapt.id"
        title="Lorem ipsum dolor sit amet."
        link="`#`"
        class="skeleton-text skeleton-effect-blink"
        text=""
      >
      </f7-list-item>
    </f7-list>

<f7-list v-else class="margin-t-b-10">
    <template v-for="(chapt) in chapters" >  
        <f7-list-item
            v-if="chapt.parent_id == parentChaptId"
            :key="chapt.id" 
            :title="chapt.name"
            :link="`/types/${chapt.id}/${chapt.name}`"
        ></f7-list-item>
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
        return {
            loading: false,
            chapters: this.$f7.data.chapters,
            parentChaptId: this.$f7route.params.id,
            chaptName: this.$f7route.params.chaptName,
        }
    },
    computed: {
        
    },
    mounted () {

    }   
};
</script>
