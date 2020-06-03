<template>
  <f7-page name="registration">
    <f7-navbar title="Conros.ru" back-link="Back"></f7-navbar>

    <f7-block-title>Регистрация нового пользователя</f7-block-title>
    <f7-list no-hairlines-md>
      <f7-list-input
        label="Имя"
        type="text"
        placeholder="Имя"
      ></f7-list-input>

      <f7-list-input
        label="E-mail"
        type="email"
        placeholder="E-mail"
      ></f7-list-input>

      <f7-list-input
        label="Пароль"
        type="password"
        placeholder="Пароль"
      ></f7-list-input>

      <f7-list-input
        label="Телефон"
        type="tel"
        placeholder="Телефон"
      ></f7-list-input>

      <f7-list-input
        label="Дата рождения"
        type="date"
        placeholder="Birth day"
        defaultValue="1975-04-30"
      ></f7-list-input>
    </f7-list>
    <f7-block>
        <f7-button class="col" outline>Зарегистрироваться</f7-button>
    </f7-block>
    
  </f7-page>
</template>
