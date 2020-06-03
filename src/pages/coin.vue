<template>
    <f7-page name="coin">
        <f7-navbar :title="coin.title" back-link="Назад"></f7-navbar>

        <f7-card class="demo-card-header-pic">
           <f7-card-header>Информация о монете: <br>{{coin.title}}</f7-card-header>
        <f7-card-content>
            <img :src="coin.cover" width="100%" />
            <p>{{coin.description}}</p>
            <f7-block class="mt-1 mb-1">Цена: <font style="font-size: 18px;">{{coin.price}}</font> руб.</f7-block>
        </f7-card-content>
        <f7-card-footer>
            <f7-link>Добавить в мою коллекцию</f7-link>
        </f7-card-footer>
        </f7-card>
    </f7-page>
</template>
<script>
export default {
    data () {
    var coinId = this.$f7route.params.id;
    var currentCoin;
    this.$f7.data.coins.forEach(function (coin) {
        if (coin.id ===coinId) {
        currentCoin = coin;
        }
    });
    return {
        coin: currentCoin,
    };
    },
    methods: {
    tapclick() {
        console.log('TapClick')
    }
    },
};
</script>
