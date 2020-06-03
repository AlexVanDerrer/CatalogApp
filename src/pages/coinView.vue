<template>
    <f7-page name="coinView">
        <f7-navbar back-link>
            <f7-nav-title :title="chaptName" ></f7-nav-title>
            <!-- <f7-nav-right><span class="type-label">{{type}}</span></f7-nav-right> -->

        </f7-navbar>

        <f7-card
            v-if="loading"
            class="skeleton-text"
            title="Card Header"
            content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lobortis et massa ac interdum. Cras consequat felis at consequat hendrerit."
            footer="Card Footer"
        ></f7-card>


        <f7-card v-else class="demo-card-header-pic">
              <f7-card-header>{{coin.nominal}} {{coin.priznaki}} <span style="font-weight: bold; color: #b29a65;">{{coin.typ}}/{{coin.vid}}</span>  </f7-card-header>
        <f7-card-content>
            <f7-swiper>
                <f7-swiper-slide>
                    <img v-if="coin.revers == ''" src="http://conros.cr.local/mobile/nophoto.png" width="100%" />
                    <img v-else :src="'http://conros.cr.local/mobile/catalog_img/10/'+coin.revers" width="100%" />
                </f7-swiper-slide>
 
                <f7-swiper-slide >
                    <img v-if="coin.avers == ''" src="http://conros.cr.local/mobile/nophoto.png" width="100%" />
                    <img v-else :src="'http://conros.cr.local/mobile/catalog_img/10/'+coin.avers" width="100%" />
                </f7-swiper-slide>   
            </f7-swiper>
            
            <f7-block class="margin-top margin-bottom">
               
                <f7-row>
                    <f7-col>
                        <span v-if="label">Тип: {{label}}</span><br> 
                        <span v-if="vid">Вид: {{vid}}</span><br> 
                        <span v-if="coin.god">Год: {{coin.god}}</span><br>
                        <span v-if="coin.dvor">Монетный двор: {{coin.dvor}}</span><br> 
                        <span v-if="coin.gurt">Гурт: {{coin.gurt}}</span><br>
                        </f7-col>
                    <f7-col>
                        <span v-if="coin.met">Металл: {{coin.met}}</span><br>
                        <span v-if="coin.proba">Проба: {{coin.proba}}</span><br> 
                        <span v-if="coin.ves">Ном. вес: {{coin.ves}} гр.</span> 
                    </f7-col>
                </f7-row>
            </f7-block>
               
            <f7-block v-if="coin.desc" class="margin-top margin-bottom">
                    <f7-block-title class="no-margin-left">Описание: </f7-block-title>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, rerum provident 
                    tempora placeat sunt expedita vitae, odio cumque libero quidem asperiores voluptatum 
                    facilis modi, perferendis ex laborum a consequatur. Asperiores?
            </f7-block>

        </f7-card-content>
        <!-- <f7-card-footer>

        </f7-card-footer> -->
        </f7-card>

<f7-fab position="right-bottom" slot="fixed" text="" color="#b29a65" >
    <f7-link color="white" icon-ios="f7:arrow_left" icon-aurora="f7:arrow_left" icon-md="material:arrow_back" back></f7-link>
</f7-fab>
    </f7-page>
</template>
<script>
export default {
    data () {
        return {
            coin: [],
            chaptName: this.$f7route.params.chapt,
            type: this.$f7route.params.type, // С11
            vid: this.$f7route.params.vid,
            label: this.$f7route.params.label, // 1.1
            loading: false
    };
    },
    mounted () {
        // param  ТИП
        // patam2 ВИД
        var formData = {book: 10, action: 'get_data', tbl: 'kinds', param: this.type, param2: this.vid}
        if (this.loading) return;
        this.loading = true;
        this.$http
            .get('http://conros.cr.local/mobile/backend_mobile_cat.php', {params: formData})
            .then(response => {
                //console.log(response.body[0]);
                this.coin = response.body[0];
                this.loading = false;
        });
    }
};
</script>
