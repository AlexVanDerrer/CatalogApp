<template>
    <f7-page
        infinite
        :infinite-distance="10"
        :infinite-preloader="showPreloader"
        @infinite="infiniteScroll"
    >
        <f7-navbar >
            <f7-nav-left>
                <img :src="$f7.data.mainUrl+'/mobile/logo.png'" width="45" />
            </f7-nav-left>

            <f7-nav-title>Поиск монет</f7-nav-title>

        </f7-navbar>

        <f7-fab position="right-bottom" slot="fixed" text="" color="#b29a65">
            <f7-icon ios="f7:plus" aurora="f7:plus" md="material:search"></f7-icon>
            <f7-link slot="text" color="white" popup-open="#search-popup">Фильтр</f7-link>
        </f7-fab>
            
        <f7-block v-show="noParams">            
            <f7-row>
                <f7-col width="15"><f7-icon color="gold" f7="info_circle"></f7-icon></f7-col>
                <f7-col width="85"><span style="font-size:14px;">Добавьте фильтр для поиска</span></f7-col>
            </f7-row>
        </f7-block>
        
        <f7-block v-show="showNoResult">            
            <f7-row>
                <f7-col width="15"><f7-icon color="gold" f7="info_circle"></f7-icon></f7-col>
                <f7-col width="85"><span style="font-size:14px;">По Вашему запросу ничего не найдено.</span> </f7-col>
            </f7-row>
        </f7-block>
    
        <f7-block v-show="showCountResult" class="margin-vertical-half"> 
            <span style="font-size:18px;">Найдено - <b>{{searchArr.length}}</b></span>     
        </f7-block>

        <template v-if="viewArr != []">
            <f7-list media-list  class="margin-vertical-half">
                <template v-for="s in viewArr" > 
                    <f7-list-item
                        swipeout
                        :key="s.id"
                        :link="`/coinview/${s.vid}/${s.typ}/${s.typ_label}/${s.name}`"
                    >
                        <span slot="header" class="normal-white-space" >{{s.name}}</span>
                        <span slot="title" class="normal-white-space" ><b style="color:#b29a65; margin-right:10px;">{{s.typ_label+'/'+s.vid}}</b> {{s.nominal}}</span>
                        <span slot="text" class="normal-white-space"  v-if="s.priznaki">{{s.priznaki}}</span>
                        <span slot="footer" class="normal-white-space" >{{s.god+' '+s.met}}</span>
                        <img v-if="s.revers != ''" slot="media" :src="$f7.data.mainUrl+'/mobile/catalog_img/10/thumb/'+s.revers" width="60" />
                        <img v-else slot="media" :src="$f7.data.mainUrl+'/mobile/nophoto.jpg'" width="60" />
                        <f7-swipeout-actions right>
                            <f7-swipeout-button delete confirm-text="Удалить монету из списка?">Не показывать</f7-swipeout-button>
                        </f7-swipeout-actions>
                    </f7-list-item>
                </template>
            </f7-list>
        </template>

    <!-- Search Popup -->
        <f7-popup id="search-popup" swipeToClose>
           <f7-view>
                <f7-page>
                    <f7-navbar>
                        <f7-nav-left>
                            <f7-link v-if="this.query_param_nom || this.query_param_god || this.query_param_met" @click="clearSearch">Сброс</f7-link>
                        </f7-nav-left>
                        <f7-nav-title>Фильтры</f7-nav-title>
                        <f7-nav-right>
                            <f7-link popup-close>Закрыть</f7-link>
                        </f7-nav-right>
                    </f7-navbar>
                    
                    <f7-list no-hairlines-md>
                        
                        <!-- Номинал -->
                        <f7-list-item
                            title="Номинал" 
                            smart-select
                            :after="query_param_nom" 
                            :smart-select-params="{
                                    openIn: 'sheet', 
                                    closeOnSelect: true, 
                                    sheetCloseLinkText: 'Готово', 
                                    setValueText: false
                        
                                }"
                        >
                            <select name="nominal" v-model="query_param_nom">
                                <option 
                                    v-for="(nominal) in nominals"
                                    :key="nominal.id"
                                    :value="nominal.nominal"
                                >{{nominal.nominal}}</option>
                            </select>
                        </f7-list-item>

                        <!-- Год  -->
                        <f7-list-item  
                            title="Год"
                            :after="query_param_god" 
                            smart-select 
                            :smart-select-params="{
                                openIn: 'sheet', 
                                closeOnSelect: true, 
                                sheetCloseLinkText: 'Готово', 
                                setValueText: false
                            }"
                        >
                            <select name="god" v-model="query_param_god">
                                <option 
                                    v-for="(year) in years"
                                    :key="year.god"
                                    :value="year.god"
                                >{{year.god}}</option>
                            </select>
                        </f7-list-item>

                        <!-- Металл -->
                        <f7-list-item
                            title="Металл" 
                            smart-select
                            :after="query_param_met" 
                            :smart-select-params="{
                                openIn: 'sheet', 
                                closeOnSelect: true, 
                                sheetCloseLinkText: 'Готово',
                                setValueText: false
                            }"
                        >
                            <select name="metal" v-model="query_param_met">
                                <option 
                                    v-for="(metal) in metals"
                                    :key="metal.id"
                                    :value="metal.me"
                                >{{metal.name}}</option>
                            </select>
                        </f7-list-item>
                    </f7-list>

                    <f7-block>
                        <f7-row justify-content-center>
                            <f7-col>
                                <f7-button fill raised large @click="getSearch()" popup-close>Искать</f7-button>
                            </f7-col>
                        </f7-row>
                        
                    </f7-block>


                           


                </f7-page>
            </f7-view>
        </f7-popup>
            
    </f7-page>
</template>
<script>
export default {
    data () {
        return {
            /* параметры выбранные пользователем для запроса */
            query_param_nom: '', 
            query_param_god: '',
            query_param_met: '',
            /* end */
            metals: [], // массив для smartSelect 
            nominals: [], // -//-
            years: [], // -//-
            searchArr: [], // общий массив
            viewArr: [], // массив вывода
            countOnPage: 7, // количество строк для infiniteScroll
            showNoResult: false, // сообщение Ничего не найдено
            showCountResult: false, // количество строк в общем массиве
            showPreloader: false, // отключить прелоадер
            allowInfinite: true, // разрешить бесконечную прокрутку
            noParams: true, // сообщение не выбран фильтр
        }
    },
    methods: {
        getSearch () {
            var searchArr = {
                book: this.$f7.data.book_id, 
                action: 'get_data', 
                tbl: 'search', 
                param: this.query_param_nom, // param  Номинал
                param2: this.query_param_god,  // patam2 Год
                param3: this.query_param_met  // param3 Металл
            }
            // console.log(searchArr);
            this.$http
                .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: searchArr})
                .then(response => {  // обрабатываем промис
                        if (this.viewArr != []) this.searchArr = this.viewArr = []; //чистим массив поиска, если ранее были результаты
                        this.showPreloader = true; // показать прелоадер
                        this.showNoResult = false; //выкл сообщение Ничего не найдено
                        this.showCountResult = false; // выкл количество найденных строк
                        this.noParams = false; //выкл сообщение Не задан фильтр
                        if (response.body == false) { // если пустая выборка?
                            setTimeout(() => { // через 1 секунду
                                this.showNoResult = true; // показать сообщение Ничего не найдено
                                this.showCountResult = false; // выкл количество найденных строк
                                this.showPreloader = false; // выкл прелоадер
                                this.allowInfinite = false; // выкл инф прокрутку   
                            }, 1000);
                        } else {
                            setTimeout(() => { // через 1 секунду
                                this.searchArr = response.body; // общий массив поиска
                                this.viewArr = this.searchArr.slice(0, this.countOnPage); // записываем в массив вывода первые 10 элементов из общего
                                this.showCountResult = true; // показать кол-во найденных строк
                                this.showPreloader = false; // выкл прелоадер
                                this.allowInfinite = true;  // вкл инф прокрутку           
                            }, 1000);
                        }
                },
                responce => { console.log('error'); /* callback в случае ошибки запроса */}); 
   
        },
        clearSearch () {
            this.searchArr = this.viewArr = []; 
            this.noParams = true; 
            this.showCountResult = false;
            this.showNoResult = false;
            this.showPreloader = false;
            this.query_param_nom = '';
            this.query_param_god = '';
            this.query_param_met = '';
        },
        infiniteScroll() {
            if (this.allowInfinite == false) return; 
            this.allowInfinite = false;
            this.showPreloader = true;
            setTimeout(() => {
                let index =  this.viewArr.length - 1;
                for (let i = 1; i <= this.countOnPage; i += 1) {
                    if (this.viewArr.length == this.searchArr.length) {
                        this.showPreloader = false;
                        return;
                    }
                    this.viewArr.push(this.searchArr[index + i]);
                }
                // console.log(this.viewArr);
                this.allowInfinite = true;
            }, 1000);
        },
    },
    mounted() {
        var metalArr = {book: this.$f7.data.book_id, action: 'get_data', tbl: 'metal'}
        this.$http
            .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: metalArr})
            .then(response => {
                this.metals = response.body;
        });
        var nominalArr = {book: this.$f7.data.book_id, action: 'get_data', tbl: 'nominal'}
        this.$http
            .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: nominalArr})
            .then(response => {
                //console.log(response.body);
                this.nominals = response.body;
                // console.log(this.nominals);
        });
        var years = {book: this.$f7.data.book_id, action: 'get_data', tbl: 'year'}
        this.$http
            .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: years})
            .then(response => {
                //console.log(response.body);
                this.years = response.body;
                // console.log(this.years);
        });
    },
}
</script>
