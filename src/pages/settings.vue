<template>
    <f7-page name="settings">
        <f7-navbar back-link>

            <f7-nav-title title="Информация"></f7-nav-title>

            <f7-nav-right>
                <img src="http://conros.cr.local/mobile/logo.png" width="45" />
            </f7-nav-right>

        </f7-navbar>

        <f7-list>
            <f7-list-item link="/about/" title="О каталоге"></f7-list-item>
            <!-- <f7-list-item link="/help/" title="Помощь"></f7-list-item> -->
            <f7-list-item link="/ask/" title="Задать вопрос"></f7-list-item>
            <f7-list-item :link="`/faq/${id}`" title="Частые вопросы"></f7-list-item>
        </f7-list>

    </f7-page>
</template>
<script>
export default {
    data () {
        return {
            id: 10
        }
    }
}
</script>
