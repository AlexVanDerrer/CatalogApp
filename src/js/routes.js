import HomePage from '../pages/home.vue';
import AboutPage from '../pages/about.vue';
import CollectionPage from '../pages/collection.vue';
import AuthPage from '../pages/auth_view.vue';
import SettingsPage from '../pages/settings.vue';
import TypePage from '../pages/types.vue';
import KindPage from '../pages/kinds.vue';
import CoinViewPage from '../pages/coinView.vue';
import CustCoinViewPage from '../pages/custCoinView.vue';
import SubChapPage from '../pages/subchapters.vue';
import SearchPage from '../pages/search_view.vue';
// import AskPage from '../pages/ask.vue';
import faqPage from '../pages/faq.vue';
import NotFoundPage from '../pages/404.vue';

var routes = [
  {
    path: '/', // Home
    component: HomePage,
  },
  {
    path: '/types/:id/:name',
    component: TypePage,
  },
  {
    path: '/subchapters/:id/:chaptName',
    component: SubChapPage,
  },
  {
    path: '/kinds/:id/:name/:title/:type/:chapt',
    component: KindPage,
  },
  {
    path: '/coinview/:vid/:type/:label/:chapt',
    component: CoinViewPage,
  },
  {
    path: '/custcoinview/:vid/:type/:label/:id',
    component: CustCoinViewPage,
  },
  {
    path: '/search/',
    component: SearchPage,
  },
  {
    path: '/collection/',
    component: CollectionPage,
  },
  {
    path: '/authview/:email',
    component: AuthPage,
  },
  {
    path: '/settings/',
    component: SettingsPage,
  },
  {
    path: '/about/',
    component: AboutPage,
  },
  { /* Асинхронный роут (оставил просто для примера) */
    path: '/faq/:id',
    async: function (routeTo, routeFrom, resolve, reject) {
      var router = this;
      var app = router.app;
      // показать прелоадер
      app.preloader.show();
      var userId = routeTo.params.id;

      // Имитация Ajax запроса
      setTimeout(function () {
        // Типа обрабатываем промис
        var post = { // ? {}, [], string, number
          name: 'Vladimir',
          question: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, neque!', 
          description: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, neque!',
        };
        // Скрыть прелоадер
        app.preloader.hide();

        // свойства компонента
        resolve(
          {
            component: faqPage, // какой компонент показать
          },
          {
            context: {
              post: post, // какие данные передаются в компонент
            }
          }
        );
      }, 500);
    }
  },
  { // 404
    path: '(.*)', 
    component: NotFoundPage,
  },
  // {
  //   path: '/ask/',
  //   component: AskPage,
  // },
];

export default routes;
