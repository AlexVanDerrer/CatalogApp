<template>
    <f7-page 
        name="kinds"
        infinite
        :infinite-distance="10"
        :infinite-preloader="loading"
        @infinite="infiniteScroll">
        <f7-navbar back-link >
            <f7-nav-title :title="chaptName" ></f7-nav-title>
        </f7-navbar>

        <f7-block strong class="margin-vertical-half">
            <f7-block-title medium class="no-margin">
                <span class="type-label">{{type}}</span>
                <span style="margin-left: 20px;">{{title}}</span>
            </f7-block-title>
        </f7-block>

        <f7-list  media-list class="margin-t-b-10">
            <template v-for="(kind) in viewArr"> 
                <f7-list-item
                    swipeout
                    :key="kind.id"
                    :link="`/coinview/${kind.vid}/${$f7route.params.name}/${type}/${chaptName}`"
                >
                    <span slot="title" class="normal-white-space" v-if="kind.priznaki"><span style="font-weight: bold; color: #b29a65;">{{kind.vid}}.</span> {{kind.priznaki}}</span>
                    <span slot="title" class="normal-white-space" v-else><span style="font-weight: bold; color: #b29a65;">{{kind.vid}}.</span> {{title}}</span>
                    <span slot="text" class="mr-5">{{kind.god}}</span>
                    <span slot="text" v-if="kind.dvor" class="mr-5">{{kind.dvor}}</span>
                    <span slot="text" v-if="kind.met" class="mr-5">{{kind.met}}</span>
                    <span slot="text" v-if="kind.gurt" class="mr-5">{{kind.gurt}}</span>
                    <span slot="text" v-if="kind.minz" class="mr-5">{{kind.minz}}</span>
                    <img v-if="kind.revers != ''" slot="media" :src="$f7.data.mainUrl+'/mobile/catalog_img/10/thumb/'+kind.revers" width="60" />
                    <img v-else-if="kind.avers != ''" slot="media" :src="$f7.data.mainUrl+'/mobile/catalog_img/10/thumb/'+kind.avers" width="60" />
                    <img v-else slot="media" :src="$f7.data.mainUrl+'/mobile/nophoto.jpg'" width="60" />
                </f7-list-item>
            </template>
        </f7-list>
        <!-- back-link button -->
        <f7-fab position="right-bottom" slot="fixed" text="" color="#b29a65" >
            <f7-link color="white" icon-ios="f7:arrow_left" icon-aurora="f7:arrow_left" icon-md="material:arrow_back" back></f7-link>
        </f7-fab>

    </f7-page>
</template>
<script>
export default {
    data () {
        return {
            countOnPage: 7, // количество строк для infiniteScroll
            kinds: [], // общий массив
            viewArr: [], // массив вывода
            title: this.$f7route.params.title,
            chaptName: this.$f7route.params.chapt,
            type: this.$f7route.params.type,
            loading: false,
            allowInfinite: true, // разрешить бесконечную прокрутку
            
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
    mounted () {
        var formData = {book: this.$f7.data.book_id, action: 'get_data', tbl: 'kinds', param: this.$f7route.params.name};
        if (this.loading) return;
        this.loading = true;
        this.$http
            .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: formData})
            .then(response => {
                this.kinds = response.body; 
                this.viewArr = this.kinds.slice(0, this.countOnPage); // записываем в массив вывода первые countOnPage элементов из общего
                this.allowInfinite = true;  // вкл инф прокрутку  
                this.loading = false;
            });
    }
};
</script>

