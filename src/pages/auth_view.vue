<template>
  <f7-page name="authview">
    <f7-navbar title="Вход в аккаунт" back-link="Back"></f7-navbar>

    <f7-fab position="right-bottom" slot="fixed" text="" color="#b29a65" >
        <f7-link color="white" icon-ios="f7:arrow_left" icon-aurora="f7:arrow_left" icon-md="material:arrow_back" back></f7-link>
    </f7-fab>

    <f7-block v-if="isReg == undefined" class="text-align-center">
        <f7-preloader color="#b29a65"></f7-preloader>
    </f7-block>

    <template  v-else-if="isReg == false">  
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
                label="Введите пароль"
                floating-label
                :value="custPwd"
                type="password"
                placeholder="Пароль"
                @input="custPwd = $event.target.value"
                clear-button
            ></f7-list-input>
        </f7-list>

        <f7-block v-if="custPwd != '' && custPwd != undefined">
            <f7-button fill raised @click="userAuth()">Вход</f7-button>
        </f7-block>

        <f7-block class="no-margin" v-if="badPwd">
            <f7-row>
                <f7-col width="15"><f7-icon style="color:#b29a65;" f7="info_circle"></f7-icon></f7-col>
                <f7-col width="85">Неверный пароль!</f7-col>       
            </f7-row>
        </f7-block> 

    </template>

  </f7-page>
</template>
<script>
export default {
    data () {
       return {
           loading: true,
           email: '',
           custPwd: '',
           checkPwd: '',
           isReg: undefined, 
           badPwd: false,
           hash: '',
        
        }
    },
    methods: {
        userAuth () {
            let formData = new FormData();
            formData.append("book", 10);
            formData.append("action", "auth");
            formData.append("email", this.email);
            formData.append("pwd", this.custPwd);
            this.$http
                .post('http://conros.cr.local/mobile/backend_mobile_cat.php', formData)
                .then(response => {
                    console.log(response.body.status);
                    console.log(response.body.hash);
                    if (response.body.status) {
                        window.localStorage.setItem('auth', response.body.hash);
                        this.$f7router.navigate('/collection/')
                    } else {
                        console.log(response.body.message);
                        this.badPwd = true;
                    }

            }, () => {/*callback функция если промис вернулся с ошибкой*/}); 

        },
        /** Новая регистрация */
        doReg () {
            let formData = new FormData();
            formData.append("book", 10);
            formData.append("action", "registration");
            formData.append("email", this.email);
            formData.append("pwd", this.custPwd);
            this.$http
                .post('http://conros.cr.local/mobile/backend_mobile_cat.php', formData)
                .then(response => {
                    // if (response.body.status)

                    console.log(response.body.status);
                    console.log(response.body.hash);
                    window.localStorage.setItem('auth', response.body.hash);
                    this.$f7router.navigate('/collection/')
            }, () => {/*callback функция если промис вернулся с ошибкой*/}); 
            

        },

    },
    mounted () {
        /** Проверка email в базе */
        this.email = this.$f7route.params.email;
        var formData = {book: 10, action: 'get_data', tbl: 'check_email', email: this.email}
        // console.log(formData)
        this.$http
            .get('http://conros.cr.local/mobile/backend_mobile_cat.php', {params: formData})
            .then(response => {
                if (response.body[0][0] != '0') { 
                    this.loading = false;
                    this.isReg = true;
                } else {
                    this.loading = false;
                    this.isReg = false;
                }
        }, () => {/*callback функция если промис вернулся с ошибкой*/});
    }
}
</script>