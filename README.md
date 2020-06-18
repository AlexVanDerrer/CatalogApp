# CatalogConros

## NPM Скрипты

* 🔥 `start` - Запустить webpack-dev-server
* 🔧 `dev` - Запустить webpack-dev-server
* 🔧 `build-dev` - сборка веб-приложения в режиме разработки (более быстрая сборка без минимизации и оптимизации)
* 🔧 `build-prod` - сборка для продакшн
* 📱 `build-dev-cordova` - сборка приложения cordova в режиме разработки
* 📱 `build-prod-cordova` - сборка приложения cordova для продакшн
* 📱 `build-dev-cordova-ios` - сборка приложения cordova iOS в режиме разработки
* 📱 `build-prod-cordova-ios` - сборка приложения cordova iOS для продакшн
* 📱 `build-dev-cordova-android` - сборка приложения cordova Android в режиме разработки
* 📱 `build-prod-cordova-android` - сборка приложения cordova Android для продакшн

### Пример использования
```
npm run [NameScript]

```
Результат сборки веб-приложения с помощью WebPack помещается в каталог `/www` в корне каталога приложения

## WebPack

Существует config пакета webpack bundle. Он компилирует и связывает все "front-end" ресурсы. 
Webpack config находится в `build/webpack.config.js`.
Вся разработка ведется только в каталоге `/src`. 

## Cordova

Проект Cordova находится в каталоге  `/cordova`. 
Чтобы начать сборку приложения под android, необходимо переместить содержимое и каталога `/www` в каталог `/cordova/www` 
Добавьте флаг `--release` для сборки релизной версии

## For Example
### ведем разработку
```
npm run dev
```
### Собираем билд 
```
npm run build-prod
```

### Собираем приложение Cordova Android
```
/cordova> cordova build android 
```

## Документация & Ресурсы

* [Vue.js](https://ru.vuejs.org/v2/guide/)

* [Framework7 Core Documentation](https://framework7.io/docs/)
* [Framework7 Vue Documentation](https://framework7.io/vue/)
* [Framework7 Icons Reference](https://framework7.io/icons/)
* [Community Forum](https://forum.framework7.io)

* [Cordova Documentation](https://cordova.apache.org/docs/en/latest/)
* [Webpack Getting Started](https://webpack.js.org/guides/getting-started/)