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
            <template  v-if="isAvailable == false">
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
                        <f7-button fill raised  @click="checkEmail">Продолжить</f7-button>
                    </f7-block>
                
           </template>

           <template  v-if="isReg == false">  
                <f7-list no-hairlines-md class="margin-vertical-half">
                    <f7-list-input
                        outline
                        label="Пароль"
                        floating-label
                        type="password"
                        :value="custPwd"
                        placeholder="Придумайте пароль"
                        @input="custPwd = $event.target.value"
                        clear-button
                    ></f7-list-input>
                    <f7-list-input
                        outline
                        label="Подтверждение пароля"
                        floating-label
                        type="password"
                        :value="checkPwd"
                        placeholder="Подтверждение пароля"
                        @input="checkPwd = $event.target.value"
                        clear-button
                    ></f7-list-input>
                </f7-list>
                

                <f7-block v-if="custPwd != '' && custPwd == checkPwd">
                    <f7-button fill raised  @click="doReg()">Вход</f7-button>
                </f7-block>
                
                <f7-block class="no-margin" v-else-if="custPwd == '' && checkPwd == ''">
                    <f7-row>
                        <f7-col width="15"><f7-icon style="color:#b29a65;" f7="info_circle"></f7-icon></f7-col>
                        <f7-col width="85">Поля не заполнены!</f7-col>       
                    </f7-row>
                </f7-block>
                <f7-block class="no-margin" v-else>
                    <f7-row>
                        <f7-col width="15"><f7-icon style="color:#b29a65;" f7="info_circle"></f7-icon></f7-col>
                        <f7-col width="85">Пароли не совпадают!</f7-col>       
                    </f7-row>
                </f7-block>
               
           </template>

           <template v-else-if="isReg == true">
                <f7-list no-hairlines-md class="margin-vertical-half">
                    <f7-list-input
                        outline
                        label="Пароль"
                        floating-label
                        :value="custPwd"
                        type="password"
                        placeholder="Пароль"
                        @input="custPwd = $event.target.value"
                        clear-button
                    ></f7-list-input>
                </f7-list>

                <f7-block v-if="custPwd != '' && custPwd != undefined">
                    <f7-button fill raised  @click="userAuth()">Вход</f7-button>
                </f7-block>
           </template>

        


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
                    <!-- <span slot="text" v-if="kind.dvor" class="mr-5">{{kind.dvor}}</span>
                    <span slot="text" v-if="kind.met" class="mr-5">{{kind.met}}</span>
                    <span slot="text" v-if="kind.gurt" class="mr-5">{{kind.gurt}}</span>
                    <span slot="text" v-if="kind.minz" class="mr-5">{{kind.minz}}</span> -->


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
            Auth: window.localStorage.auth, // наличие авторизации в LocalStorage
            isReg: undefined, // имеется ли регистрация
            isAvailable: false, // имеется ли запись в базе
            nextBtn: false, // показать/скрыть кнопку Продолжить
            custEmail: '', 
            custPwd: '',
            checkPwd: '',

        };
    },
    methods: {
        /** Авторизация пользователя */
        userAuth () {
            window.localStorage.setItem('auth', true);
            this.Auth = true;
        },
        /** Проверка email в базе */
        checkEmail () {
            // console.log(this.custEmail)
            var formData = {book: 10, action: 'get_data', tbl: 'check_email', email: this.custEmail}
            console.log(formData)
            this.$http
                .get('http://conros.cr.local/mobile/backend_mobile_cat.php', {params: formData})
                .then(response => {
                    if (response.body[0][0] != '0') { 
                        this.isAvailable = true;
                        this.isReg = true;
                    } else {
                        this.isAvailable = true;
                        this.isReg = false;
                    }
            }, () => {/*callback функция если промис вернулся с ошибкой*/});
 
        },
        /** Новая регистрация */
        doReg () {
            
            var formData = {book: 10, action: 'registration', email: this.custEmail, pwd: this.custPwd}
            this.$http
                .post('http://conros.cr.local/mobile/backend_mobile_cat.php', {params: formData})
                .then(response => {
                    console.log(response.body);
                    this.isAvailable = true;
            }, () => {/*callback функция если промис вернулся с ошибкой*/}); 
            window.localStorage.setItem('auth', true);
            this.Auth = true;

        },
        /** Выход из Аккаунта */
        exitApp () {
            window.localStorage.removeItem('auth');
            this.Auth = undefined;
            this.isReg = undefined,
            this.isAvailable = false;
            this.custPwd = '';
            this.checkPwd ='';
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