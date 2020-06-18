/* Vuex — паттерн управления состоянием для приложений на Vue.js.  */
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        test: [] 
    },
    /*
    Геттеры - вычисляемыми свойствами хранилища. Как и вычисляемые свойства (computed: {}), 
    результаты геттера кэшируются, на основе его зависимостей и пересчитываются 
    только при изменении одной из зависимостей.
    */
    getters: {

    },
    /* 
    Мутации - единственный способом изменения состояния хранилища во Vuex. 
    Мутации во Vuex очень похожи на события: каждая мутация имеет строковый тип и 
    функцию-обработчик. В этом обработчике и происходят, собственно, изменения состояния, 
    переданного в функцию первым аргументом.
    */
    mutations: {
        setData (state, payload) {
            return state.test = payload
        }
    },
    /*
    Действия — похожи на мутации с несколькими отличиями:
    - Вместо того, чтобы напрямую менять состояние, действия инициируют мутации;
    - Действия могут использоваться для асинхронных операций.
    */
    actions: {
        /* не используется */
        getData (context, payload) {
            var formData = {book: this.$f7.data.book_id, action: 'get_data', tbl: 'contents'}
            this.$http
                .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: formData})
                .then(response => {
                    state.test = response.body; 
            });
            
        }
    }
})
