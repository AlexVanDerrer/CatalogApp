<template>
    <f7-page 
        name="kinds"
        infinite
        :infinite-distance="10"
        :infinite-preloader="loading"
        @infinite="infiniteScroll">
        <f7-navbar back-link >
            <f7-nav-title :title="chaptName" ></f7-nav-title>
            <!-- <f7-nav-right><span class="type-label">{{type}}</span></f7-nav-right> -->
             

        </f7-navbar>




<f7-block strong class="margin-vertical-half">
    <f7-block-title medium class="no-margin">
        <span class="type-label">{{type}}</span>
        <span style="margin-left: 20px;">{{title}}</span>
    </f7-block-title>
</f7-block>

    <!-- <f7-block  v-if="loading" class="row demo-preloaders align-items-stretch text-align-center">
      <f7-col>
        <f7-preloader :size="56" color="#b29a65"></f7-preloader>
      </f7-col>
    </f7-block> -->



    <!-- <f7-list media-list v-if="loading" class="margin-vertical-half">
      <f7-list-item
        v-for="(kind) in kinds"
        :key="kind.id"
        header="Lorem ipsum dolor sit amet."
        title="Lorem ipsum dolor sit amet. "
        :link="`#`"
        :class="`skeleton-text skeleton-effect-blink`"
        text= "Lorem ipsum dolor sit amet."
      >
        <f7-skeleton-block style="width: 40px; height: 40px; border-radius: 50%" slot="media"></f7-skeleton-block>
      </f7-list-item>
    </f7-list> -->

<f7-list  media-list class="margin-t-b-10">
    <template v-for="(kind) in viewArr"> 
        <f7-list-item
            swipeout
            :key="kind.id"
            :link="`/coinview/${kind.vid}/${$f7route.params.name}/${type}/${chaptName}`"
        >
        
        <span slot="title" class="normal-white-space" v-if="kind.priznaki"><span style="font-weight: bold; color: #b29a65;">{{kind.vid}}.</span> {{kind.priznaki}}</span>
        <span slot="title" class="normal-white-space" v-else><span style="font-weight: bold; color: #b29a65;">{{kind.vid}}.</span> {{title}}</span>

        <!-- <span slot="subtitle" class="mr-5">subtitle</span> -->

        <span slot="text" class="mr-5">{{kind.god}}</span>
        <span slot="text" v-if="kind.dvor" class="mr-5">{{kind.dvor}}</span>
        <span slot="text" v-if="kind.met" class="mr-5">{{kind.met}}</span>
        <span slot="text" v-if="kind.gurt" class="mr-5">{{kind.gurt}}</span>
        <span slot="text" v-if="kind.minz" class="mr-5">{{kind.minz}}</span>


        <img v-if="kind.revers != ''" slot="media" :src="'http://conros.cr.local/mobile/catalog_img/10/thumb/'+kind.revers" width="60" />
        <img v-else-if="kind.avers != ''" slot="media" :src="'http://conros.cr.local/mobile/catalog_img/10/thumb/'+kind.avers" width="60" />
        <img v-else slot="media" :src="'http://conros.cr.local/mobile/nophoto.jpg'" width="60" />

        <!-- <f7-swipeout-actions right>
            <f7-swipeout-button color="green" @click="addCoin"><f7-icon ios="f7:plus" aurora="f7:plus" md="material:plus"></f7-icon></f7-swipeout-button>
        </f7-swipeout-actions>          -->
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
            countOnPage: 7, // количество строк для infiniteScroll
            kinds: [],
            title: this.$f7route.params.title,
            chaptName: this.$f7route.params.chapt,
            type: this.$f7route.params.type,
            html: '',
            loading: false,
            allowInfinite: true, // разрешить бесконечную прокрутку
            viewArr: [],


        }
    },
    methods: {
        infiniteScroll() {
            if (this.allowInfinite == false) return; 
            this.allowInfinite = false;
            this.loading = true;
            setTimeout(() => {
                let index =  this.viewArr.length - 1;
                for (let i = 1; i <= this.countOnPage; i += 1) {
                    if (this.viewArr.length == this.kinds.length) {
                        this.loading = false;
                        return;
                    }
                    this.viewArr.push(this.kinds[index + i]);
                };
                this.allowInfinite = true;
                this.loading = false;
            }, 1000);
        }, 
    },
    created() {
        
    },
    mounted () {
        var formData = {book: 10, action: 'get_data', tbl: 'kinds', param: this.$f7route.params.name};
        // console.log(formData)
        if (this.loading) return;
        this.loading = true;
        this.$http
            .get('http://conros.cr.local/mobile/backend_mobile_cat.php', {params: formData})
            .then(response => {
                this.kinds = response.body;
                this.viewArr = this.kinds.slice(0, this.countOnPage); // записываем в массив вывода первые countOnPage элементов из общего
                // console.log(this.kinds)
                
                this.allowInfinite = true;  // вкл инф прокрутку  
                this.loading = false;
            });
    }
};
</script>
<style>


</style>

