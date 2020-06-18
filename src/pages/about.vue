<template>
    <f7-page name="about">
        <f7-navbar title="О каталоге" back-link></f7-navbar>
        <f7-block strong class="no-margin">
            <f7-swiper pagination>
                <f7-swiper-slide><img :src="$f7.data.mainUrl+'/mobile/about_img/cat_img_1.jpg'" width="80%" /></f7-swiper-slide>
                <f7-swiper-slide><img :src="$f7.data.mainUrl+'/mobile/about_img/cat_img_2.jpg'" width="80%" /></f7-swiper-slide>
                <f7-swiper-slide><img :src="$f7.data.mainUrl+'/mobile/about_img/cat_img_3.jpg'" width="80%" /></f7-swiper-slide>
                <f7-swiper-slide><img :src="$f7.data.mainUrl+'/mobile/about_img/cat_img_4.jpg'" width="80%" /></f7-swiper-slide>
            </f7-swiper>
        </f7-block>

        <f7-block class="no-margin-top">
            <f7-block-title class="no-margin-left">Описание: </f7-block-title>
                <p>
                Очередная редакция каталога пополнилась всеми новинками от центрального банка России, отражены в издании все изменения цен на нумизматическом рынке. 
                Примечательны разделы драгоценных металлов, рынок штормит, что нашло четкое отражение в редакции. Привычным остается качество издания: и цветная полиграфия,
                и удобный переплет, а также стоимость справочника - все остается неизменным. Включен в редакцию и план выпуска монет ЦБР на 2021 год. Увеличено количество 
                страниц, 100! Расширен раздел недрагоценных "четвертачков", ЦБР балует нас новинками к празднику Великой Победы.
                </p>
        </f7-block>
    </f7-page>
</template>
