<template>
    <f7-page name="ask">
        <f7-navbar title="Задать вопрос" back-link="Back"></f7-navbar>

        <f7-list no-hairlines-md class="margin-vertical-half">
            <f7-list-input
                outline
                label="E-mail"
                floating-label
                type="email"
                placeholder="Введите Ваш E-mail"
                @input="custEmail = $event.target.value"
                clear-button
            ></f7-list-input>
            <f7-list-input
                outline
                label="Текст Вашего вопроса"
                floating-label
                type="textarea"
                placeholder="Напишите вопрос"
                @input="text = $event.target.value"
                clear-button
            ></f7-list-input>
        </f7-list>

        <f7-block class="margin-vertical-half">
            <f7-button fill raised @click="doAsk()">Отправить</f7-button>
        </f7-block>

    </f7-page>
</template>
<script>
export default {
    data () {
        return {
            text: '',
            custEmail: ''
        }
    },
    methods: {
        doAsk () {
            console.log(this.custEmail);
            console.log(this.text);
        }
    },
}
</script>