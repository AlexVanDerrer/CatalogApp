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
                        :link="`/coin/${coin.id}`"
                    >
                    <span slot="title" class="normal-white-space">{{coin.title}}</span>

                    <!-- <span slot="subtitle" class="mr-5">subtitle</span> -->

                    <span slot="text" class="mr-5">{{coin.price}}</span>
                    <!-- 
                    <span slot="text" v-if="kind.dvor" class="mr-5">{{kind.dvor}}</span>
                    <span slot="text" v-if="kind.met" class="mr-5">{{kind.met}}</span>
                    <span slot="text" v-if="kind.gurt" class="mr-5">{{kind.gurt}}</span>
                    <span slot="text" v-if="kind.minz" class="mr-5">{{kind.minz}}</span> 
                    -->

                    <img slot="media" :src="coin.cover" width="60" />
                   
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
            userCoins: coins, // массив монет пользователя
            Auth: undefined, // наличие авторизации 
            nextBtn: false, // показать/скрыть кнопку Продолжить
            custEmail: '', 

        };
    },
    methods: {
        /** Авторизация пользователя */
        userAuth () {

        },

        /** Выход из Аккаунта */
        exitApp () {
            window.localStorage.removeItem('auth');
            this.Auth = undefined;
        }
    },
    mounted () {
        this.Auth = window.localStorage.auth; 
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