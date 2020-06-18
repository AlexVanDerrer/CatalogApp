<template>
    <f7-page name="coinView" >
        <f7-navbar :title="chaptName"  back-link></f7-navbar>

        <!-- skeleton card -->
        <f7-card
            v-if="loading"
            class="skeleton-text"
            title="Card Header"
            content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lobortis et massa ac interdum. Cras consequat felis at consequat hendrerit."
            footer="Card Footer"
        ></f7-card>
        <!-- end skeleton card -->

        <f7-card v-else class="demo-card-header-pic">
              <f7-card-header><span><b> {{coin.nominal}}</b> {{coin.priznaki}}</span>  <span style="font-weight: bold; color: #b29a65;">{{coin.typ}}/{{coin.vid}}</span>  </f7-card-header>
        <f7-card-content>
            <f7-swiper>
                <f7-swiper-slide>
                    <img v-if="coin.revers ==  ''" :src="$f7.data.mainUrl+'/mobile/nophoto.png'" width="100%" />
                    <img v-else :src="$f7.data.mainUrl+'/mobile/catalog_img/10/'+coin.revers" width="100%" />
                </f7-swiper-slide>
 
                <f7-swiper-slide >
                    <img v-if="coin.avers == ''" :src="$f7.data.mainUrl+'/mobile/nophoto.png'" width="100%" />
                    <img v-else :src="$f7.data.mainUrl+'/mobile/catalog_img/10/'+coin.avers" width="100%" />
                </f7-swiper-slide>   
            </f7-swiper>
            
            <f7-block class="margin-top margin-bottom">
                <f7-row>
                    <f7-col>
                        <span v-if="label">Тип: {{label}}</span><br> 
                        <span v-if="vid">Вид: {{vid}}</span><br> 
                        <span v-if="coin.god">Год: <b>{{coin.god}}</b></span><br>
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
               
        </f7-card-content>

            <f7-card-footer>
                 <!-- <f7-button v-if="hash" fill raised @click="fastAddCoin"><f7-icon ios="f7:plus" aurora="f7:plus" md="material:add"></f7-icon> Добавить в коллекцию</f7-button> -->
            </f7-card-footer>

        </f7-card>

        <!-- back-link button -->
        <f7-fab position="right-bottom" slot="fixed" text="" color="#b29a65" >
            <f7-link color="white" icon-ios="f7:arrow_left" icon-aurora="f7:arrow_left" icon-md="material:arrow_back" back></f7-link>
        </f7-fab>

        <!-- <f7-fab position="left-bottom" slot="fixed" @click="fastAddCoin">
            <f7-icon ios="f7:plus" aurora="f7:plus" md="material:add"></f7-icon>
        </f7-fab> -->

        <f7-fab v-show="hash != undefined || false || null" position="left-bottom" slot="fixed">
            <f7-icon ios="f7:plus" aurora="f7:plus" md="material:menu"></f7-icon>
            <f7-icon ios="f7:xmark" aurora="f7:xmark" md="material:close"></f7-icon>
            <f7-fab-buttons position="top">
            <f7-fab-button @click="fastAddCoin" label="Добавить в коллекцию"><f7-icon ios="f7:house" aurora="f7:house" md="material:add"></f7-icon></f7-fab-button>
            <!-- <f7-fab-button><f7-icon color="red" ios="f7:house" aurora="f7:house" md="material:delete_forever"></f7-icon></f7-fab-button> -->
            </f7-fab-buttons>
        </f7-fab>



        <f7-popup id="add_coin" swipeToClose>
           <f7-view>
                <f7-page>
                    <f7-navbar>
                        <f7-nav-left>
                            
                        </f7-nav-left>
                        <f7-nav-title>Добавить монету</f7-nav-title>
                        <f7-nav-right>
                            <f7-link popup-close>Закрыть</f7-link>
                        </f7-nav-right>
                    </f7-navbar>
                    <template v-if="!getHash">
                        <f7-block strong class="no-margin">
                            <f7-row>
                                <f7-col width="15"><f7-icon style="color:#b29a65;" f7="info_circle"></f7-icon></f7-col>
                                <f7-col width="85">Чтобы управлять своей коллекциией, необходимо авторизоваться!</f7-col>       
                            </f7-row>
                        </f7-block>

                        <f7-block>
                            <f7-button fill raised href="/collection/">Продолжить</f7-button>
                        </f7-block>
                    </template>
                    <template v-else>

                            <f7-list no-hairlines-md>
                                <f7-list-input
                                    outline
                                    label="Номинал"
                                    :value="coin.nominal"
                                    floating-label
                                    type="text"
                                    placeholder="Номинал"
                                    clear-button
                                >
                                </f7-list-input>
                                <f7-list-input
                                    outline
                                    label="Признаки"
                                    :value="coin.priznaki"
                                    floating-label
                                    type="text"
                                    placeholder="Your name"
                                    clear-button
                                >
                                </f7-list-input>
                            </f7-list>
                            <f7-block>
                                <f7-row justify-content-center>
                                    <f7-col>
                                        <f7-button fill raised large @click="addCustCoin()" popup-close>Добавить</f7-button>
                                    </f7-col>
                                </f7-row> 
                            </f7-block>
    
                    </template>
                </f7-page>
            </f7-view>
        </f7-popup>

        
    </f7-page>
</template>
<script>
export default {
    data () {
        return {
            coin: [],
            chaptName: this.$f7route.params.chapt,
            type: this.$f7route.params.type, // пример С11
            vid: this.$f7route.params.vid,
            label: this.$f7route.params.label, // пример 1.1
            hash: window.localStorage.auth || undefined,
            loading: false,
    };
    },
    methods: {
        fastAddCoin () {
            // this.$f7.popup.open('#add_coin');
            /* Альтернативный способ Ajax post запроса */
            let paramsObj = {
                book: this.$f7.data.book_id, 
                action: 'add_cust_coin', 
                hash: window.localStorage.auth,
                typ: this.coin.typ,
                vid: this.coin.vid,
            }

            this.$f7.request.promise
                .post(this.$f7.data.mainUrl+this.$f7.data.backend, paramsObj)
                .then((response) => {
                    const toastBottom = this.$f7.toast.create({
                        text: 'Монета успешно добавлена!',
                        closeTimeout: 2000,
                    });
                    toastBottom.open();

                }, () => {/*callback функция если промис вернулся с ошибкой*/}); 
        },
        getHash () {
            if (this.$f7.data.hash) return true
            return false;
        },
        addCustCoin() {

        },

    },
    mounted () {
        // param  ТИП
        // patam2 ВИД
        var formData = {book: this.$f7.data.book_id, action: 'get_data', tbl: 'kinds', param: this.type, param2: this.vid}
        if (this.loading) return;
        this.loading = true;
        this.$http
            .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: formData})
            .then(response => {
                //console.log(response.body[0]);
                this.coin = response.body[0];
                this.loading = false;
        });
    }
};
</script>
