<template>
    <f7-app :params="f7params" theme-light>
    <!-- Views/Tabs container -->
        <f7-views tabs class="safe-areas">
            <!-- Tabbar for switching views-tabs -->
            <f7-toolbar tabbar labels bottom>
                <f7-link tab-link="#view-home" tab-link-active icon-ios="f7:list_dash" icon-aurora="f7:list_dash" icon-md="material:format_list_bulleted" text="Каталог"></f7-link>
                <f7-link tab-link="#view-search" icon-ios="f7:search" icon-aurora="f7:search" icon-md="material:search" text="Поиск"></f7-link>
                <f7-link tab-link="#view-collection" icon-ios="f7:star" icon-aurora="f7:star" icon-md="material:star" text="Коллекция"></f7-link>
                <!-- <f7-link tab-link="#view-settings" icon-ios="f7:star" icon-aurora="f7:star" icon-md="material:settings" text="Настройки"></f7-link> -->
            </f7-toolbar>

            <!-- Your main view/tab, should have "view-main" class. It also has "tab-active" class -->
            <f7-view id="view-home" main tab tab-active url="/"></f7-view>

            <!-- collection View -->
            <f7-view id="view-collection" name="collection" tab url="/collection/"></f7-view>

            <!-- search View -->
            <f7-view id="view-search" name="search" tab url="/search/"></f7-view>

            <!-- Settings View -->
            <!-- <f7-view id="view-settings" name="settings" tab url="/settings/"></f7-view> -->
        </f7-views>

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
    
                    </template>



                </f7-page>
            </f7-view>
        </f7-popup>


    </f7-app>
</template>
<script>
    import { Device }  from 'framework7/framework7-lite.esm.bundle.js';
    import cordovaApp from '../js/cordova-app.js';
    import routes from '../js/routes.js';

    export default {
        data() {
            return {
                // Framework7 Parameters
                f7params: {
                    id: 'ru.conros', // App bundle ID
                    name: 'Каталог', // App name
                    theme: 'auto', // Automatic theme detection
                    version: 0.2,
                    // App root data
                    data: function () {
                        return {
                            hash: window.localStorage.auth,
                        };
                    },

                    // App routes
                    routes: routes,


                    // Input settings
                    input: {
                        scrollIntoViewOnFocus: Device.cordova && !Device.electron,
                        scrollIntoViewCentered: Device.cordova && !Device.electron,
                    },
                    // Cordova Statusbar settings
                    statusbar: {
                        iosOverlaysWebView: true,
                        androidOverlaysWebView: false,
                    },
                },

            }
        },
        methods: {
            alertLoginData() {
                this.$f7.dialog.alert('Имя пользователя: ' + this.username + '<br>Пароль: ' + this.password, () => {
                this.$f7.loginScreen.close();
                });
            },
            userReg () {
                this.$f7.loginScreen.close();
            },
            getHash () {
                if (this.f7.data.hash) return true
                return false;
            }
        },
        /**
         * Хук жизненного цикла. Вызывается сразу после монтирования экземпляра.
         */
        mounted() {
            this.$f7ready(function(f7) {
                // console.log(Device);
                // cordovaApp.init(f7);

                //Init cordova APIs (see cordova-app.js)
                if (Device.cordova) {
                    cordovaApp.init(f7);
                }
            // Call F7 APIs here
            });
        }
    }
</script>
<style >
    .type-label {
        background-color: black;
        color: white;
        padding: 4px;
        font-weight: bold;
    }
    .margin-t-b-10 {
        margin: 10px 0;
    }
    .mr-5 {
        margin-right: 5px;
    }
    .mt-5 {
        margin: 10px !important;
    }
    .normal-white-space {
        white-space: normal !important;
    }

    :root {
        --f7-theme-color: #b29a65;
        --f7-theme-color-rgb: 178, 154, 101;
        --f7-theme-color-shade: #9f864f;
        --f7-theme-color-tint: #c0ac80;
    }
    .skeleton-text, .skeleton-text * {
        color: #b29a65 !important;
    }
</style>