<template>
    <f7-page name="home">
        <f7-navbar >
            <f7-nav-left>
                <img :src="$f7.data.mainUrl+'/mobile/logo.png'" width="45" />
            </f7-nav-left>
            <f7-nav-title>Каталог-справочник
                <span class="subtitle" style="color: gray; font-size: 12px;">монеты РСФСР, СССР и России 1921-2021</span>
            </f7-nav-title>

            <f7-nav-right>
                <f7-link href="/settings/" icon-ios="f7:info_circle" icon-aurora="f7:seainfo_circlerch" icon-md="material:help_outline" raised></f7-link>
            </f7-nav-right>
        </f7-navbar>

        <f7-block-title >Содержание: </f7-block-title>
            <!-- skeleton -->
            <f7-list media-list v-if="loading" class="margin-t-b-10">
                <f7-list-item
                    v-for="n in 4"
                    :key="n"
                    title="Lorem ipsum dolor sit amet."
                    :link="`#`"
                    :class="`skeleton-text skeleton-effect-blink`"
                    text=""
                >
                </f7-list-item>
            </f7-list>
            <!-- end skeleton -->
        <f7-list v-else class="margin-t-b-10">
            <template v-for="(chapter) in chapters" >  
                <f7-list-item
                    v-if="chapter.parent_id == 0 && chapter.has_types == 0"
                    :key="chapter.id" 
                    :title="chapter.name"
                    :link="`/subchapters/${chapter.id}/${chapter.name}`"
                ></f7-list-item>
                <f7-list-item
                    v-else-if="chapter.parent_id == 0 && chapter.has_types == 1"
                    :key="chapter.id" 
                    :title="chapter.name"
                    :link="`/types/${chapter.id}/${chapter.name}`"
                ></f7-list-item>
            </template>

            <f7-block-footer>
                    <p>Редакция каталога №49 по состоянию на Март 2020, пополнилась всеми новинками от центрального банка России, в издании отражены все изменения цен на нумизматическом рынке.</p>
                    <p>Примечательны разделы драгоценных металлов, рынок штормит, что нашло четкое отражение в редакции.</p>
                    <p>Включен в редакцию и план выпуска монет ЦБР на 2021 год. Расширен раздел недрагоценных "четвертачков", ЦБР балует нас новинками к празднику Великой Победы.</p>
            </f7-block-footer>
        </f7-list>
    </f7-page>
</template>

<script>
export default {
    data () {
        return {
            chapters: [],
            loading: false,
        };
    },
    mounted() {
        var formData = {book: this.$f7.data.book_id, action: 'get_data', tbl: 'contents'}
        if (this.loading) return;
        this.loading = true;
        this.$http
            .get(this.$f7.data.mainUrl+this.$f7.data.backend, {params: formData})
            .then(response => { 
                this.chapters = response.body; // записываем в текущий инстанс
                this.$f7.data.chapters = response.body; // записываем в глобальные параметры f7
                this.loading = false;
        }, () => {/*callback функция если промис вернулся с ошибкой*/});
    },
}
</script>