<template>
    <f7-page name="custCoinView">
        <f7-navbar back-link>
            <f7-nav-title :title="coin.nominal+' '+coin.god+'г.'" ></f7-nav-title>

        </f7-navbar>

        <f7-card
            v-if="loading"
            class="skeleton-text"
            title="Card Header"
            content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lobortis et massa ac interdum. Cras consequat felis at consequat hendrerit."
            footer="Card Footer"
        ></f7-card>


        <f7-card v-else class="demo-card-header-pic">
              <f7-card-header><span>{{coin.priznaki}}</span>  <span style="font-weight: bold; color: #b29a65;">{{coin.typ}}/{{coin.vid}}</span></f7-card-header>
        <f7-card-content>
            
            <f7-block class="margin-top-half margin-bottom-half">
                <f7-row>
                    <f7-col>
                        <span>Тип: <b>{{label ? label : '-'}}</b></span><br> 
                        <span>Вид: <b>{{vid ? vid : '-'}}</b></span><br> 
                        <span>Год: <b>{{coin.god ? coin.god :'-'}}</b></span><br>
                        <span>Монетный двор: {{coin.dvor ? coin.dvor : '-'}}</span><br> 
                        <span>Гурт: {{coin.gurt ? coin.gurt : '-'}}</span><br>
                        <span>Металл: {{coin.met ? coin.met : '-'}}</span><br>
                        <span>Проба: {{coin.proba ? coin.proba : '-'}}</span><br> 
                        <span>Ном. вес: {{coin.ves ? coin.ves : '-'}} гр.</span><br>
                        <!-- <span>Состояние: {{coin.cond ? coin.cond : '-'}}</span><br>
                        <span>Цена {{coin.price ? coin.price : '-'}}</span><br>   -->
                    </f7-col>

                </f7-row>
            </f7-block>

        </f7-card-content>

        </f7-card>

        <f7-fab position="right-bottom" slot="fixed" text="" color="#b29a65" >
            <f7-link color="white" icon-ios="f7:arrow_left" icon-aurora="f7:arrow_left" icon-md="material:arrow_back" back></f7-link>
        </f7-fab>

        <f7-fab position="center-bottom" slot="fixed">
            <f7-icon ios="f7:plus" aurora="f7:plus" md="material:menu"></f7-icon>
            <f7-icon ios="f7:xmark" aurora="f7:xmark" md="material:close"></f7-icon>
            <f7-fab-buttons position="top">
            <f7-fab-button @click="editCustCoin(coin.cust_coin_id)"><f7-icon color="green" ios="f7:house" aurora="f7:house" md="material:edit"></f7-icon></f7-fab-button>
            <f7-fab-button><f7-icon color="red" ios="f7:house" aurora="f7:house" md="material:delete_forever"></f7-icon></f7-fab-button>
            </f7-fab-buttons>
        </f7-fab>

        
    </f7-page>
</template>
<script>
export default {
    data () {
        return {
            coin: [],
            id: this.$f7route.params.id,
            type: this.$f7route.params.type, // С11
            vid: this.$f7route.params.vid,
            label: this.$f7route.params.label, // 1.1
            loading: false
    };
    },
    methods: {
        addCoin () {
            this.$f7.popup.open('#add_coin');
        },
        /* редактировать данные монеты пользователя */
        editCustCoin (id) {
            console.log('edit '+id);
        }

    },
    mounted () {
        let formData = {book: this.$f7.data.book_id, action: 'get_customer_coins', hash: window.localStorage.auth, id: this.id}
            // console.log(formData)
        if (this.loading) return;
        this.loading = true;
        this.$http
            .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: formData})
            .then(response => {
                if (response.body) { 
                    console.log(response.body);
                    this.coin = response.body[0];
                    this.loading = false;
                } 
        }, () => {/*callback функция если промис вернулся с ошибкой*/});

        
    }
};
</script>
