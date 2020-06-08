<template>
    <f7-page name="collection">
        <f7-navbar>
            <f7-nav-left>
                <img src="http://conros.cr.local/mobile/logo.png" width="45" />
            </f7-nav-left>

            <f7-nav-title>Моя коллекция
                <span class="subtitle" style="color: gray; font-size: 12px;">монеты РСФСР, СССР и России 1921-2021</span>
            </f7-nav-title>

            <f7-nav-right v-show="Auth">
                <f7-link icon-ios="f7:square_arrow_right" icon-aurora="f7:square_arrow_right" icon-md="material:exit_to_app" @click="exitApp"></f7-link>
            </f7-nav-right>
        </f7-navbar>

        <template v-if="Auth == (false || undefined)">
            <f7-block strong class="no-margin">
                <f7-row>
                    <f7-col width="15"><f7-icon style="color:#b29a65;" f7="info_circle"></f7-icon></f7-col>
                    <f7-col width="85">Чтобы управлять своей коллекциией, введите Ваш E-mail.</f7-col>       
                </f7-row>
            </f7-block>
            <f7-list no-hairlines-md class="margin-vertical-half">
                <f7-list-input
                    outline
                    label="E-mail"
                    floating-label
                    type="email"
                    placeholder="Введите Ваш E-mail"
                    @input="custEmail = $event.target.value"
                    required
                    validate="true"
                    :onValidate="(isValid) => (isValid == true) ? nextBtn = true : nextBtn = false"
                    clear-button
                ></f7-list-input>
            </f7-list>
            <f7-block v-if="nextBtn">
                <f7-button fill raised :href="`/authview/${custEmail}`">Продолжить</f7-button>
            </f7-block>
        </template>

        <template v-else>
            <f7-list  media-list class="margin-t-b-10">
                <template v-for="(coin) in userCoins"> 
                    <f7-list-item
                    :key="coin.id"
                    :link="`/coinview/${coin.vid}/${coin.typ}/${coin.typ_label}/${coin.chapt_name}`"
                >
                <span slot="title" class="normal-white-space" v-if="coin.priznaki"><span style="font-weight: bold; color: #b29a65;">{{coin.vid}}.</span> {{coin.priznaki}}</span>
                <span slot="title" class="normal-white-space" v-else><span style="font-weight: bold; color: #b29a65;">{{coin.vid}}.</span> {{coin.nominal}}</span>

                <span slot="text" class="mr-5">{{coin.god}}</span>
                <span slot="text" v-if="coin.dvor" class="mr-5">{{coin.dvor}}</span>
                <span slot="text" v-if="coin.met" class="mr-5">{{coin.met}}</span>
                <span slot="text" v-if="coin.gurt" class="mr-5">{{coin.gurt}}</span>
                <span slot="text" v-if="coin.minz" class="mr-5">{{coin.minz}}</span>

                <img v-if="coin.revers != ''" slot="media" :src="'http://conros.cr.local/mobile/catalog_img/10/thumb/'+coin.revers" width="60" />
                <img v-else-if="coin.avers != ''" slot="media" :src="'http://conros.cr.local/mobile/catalog_img/10/thumb/'+coin.avers" width="60" />
                <img v-else slot="media" :src="'http://conros.cr.local/mobile/nophoto.jpg'" width="60" />         
                </f7-list-item>
                </template>
            </f7-list>
        </template>



    </f7-page>
</template>
<script>
import coins from '../js/userCoins.js'
export default {
    data () {
        return {
            userCoins: [], // массив монет пользователя
            Auth: this.$f7.data.hash, // наличие авторизации 
            nextBtn: false, // показать/скрыть кнопку Продолжить
            custEmail: '',

        };
    },
    methods: {
        /** Выход из Аккаунта */
        exitApp () {
            window.localStorage.removeItem('auth');
            this.Auth = undefined;
        }
    },
    mounted () { 
        if(this.Auth) {
        var formData = {book: 10, action: 'get_customer_coins', hash: this.Auth}
        // console.log(formData)
        this.$http
            .get('http://conros.cr.local/mobile/backend_mobile_cat.php', {params: formData})
            .then(response => {
                if (response.body) { 
                    console.log(response.body)
                    this.userCoins = response.body;
                } 
        }, () => {/*callback функция если промис вернулся с ошибкой*/});
        }
    }
};
</script>
<style scoped>
    .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
    }
</style>