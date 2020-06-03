import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        test: [] 
    },
    getters: {

    },
    mutations: {
        setData (state, payload) {
            return state.test = payload
        }
    },
    actions: {
        getData (context, payload) {
            var formData = {book: 10, action: 'get_data', tbl: 'contents'}
            this.$http
                .get('http://conros.cr.local/mobile/backend_mobile_cat.php', {params: formData})
                .then(response => {
                    state.test = response.body; 
            });
            
        }
    }
})
