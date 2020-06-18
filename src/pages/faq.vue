<template>
    <f7-page name="faq">
        <f7-navbar title="F.A.Q." back-link="Back"></f7-navbar>

        <f7-block>
            <f7-block-title class="normal-white-space" text-color="red">{{text.name}}</f7-block-title>
            {{id}}
            {{text.question}}
        </f7-block>

    </f7-page>
</template>
<script>
export default {
    data () {
        return {
            text: this.$f7route.context.post,
            id: this.$f7route.params.id,
        }
    },
}
</script>