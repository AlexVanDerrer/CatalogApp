
import HomePage from '../pages/home.vue';
import AboutPage from '../pages/about.vue';
import FormPage from '../pages/form.vue';
import CollectionPage from '../pages/collection.vue';
import CatalogPage from '../pages/catalog.vue';
import ProductPage from '../pages/product.vue';
import CoinPage from '../pages/coin.vue';
import UserCoinPage from '../pages/user_coin.vue';
import SettingsPage from '../pages/settings.vue';
import HelpPage from '../pages/help.vue';
import Reg from '../pages/registration.vue';
import TypePage from '../pages/types.vue';
import KindPage from '../pages/kinds.vue';
import CoinViewPage from '../pages/coinView.vue';
import SubChapPage from '../pages/subchapters.vue';
import CatalogDesc from '../pages/cat_desc.vue';
import SearchPage from '../pages/search_view.vue';
import AskPage from '../pages/ask.vue';
import faqPage from '../pages/faq.vue';

import DynamicRoutePage from '../pages/dynamic-route.vue';
import RequestAndLoad from '../pages/request-and-load.vue';
import NotFoundPage from '../pages/404.vue';

var routes = [
  {
    path: '/',
    component: HomePage,
  },
  {
    path: '/help/',
    component: HelpPage,
  },
  {
    path: '/search/',
    component: SearchPage,
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
    path: '/catalog-desc/',
    component: CatalogDesc,
  },
  {
    path: '/regist/',
    component: Reg,
  },
  {
    path: '/about/',
    component: AboutPage,
  },
  {
    path: '/form/',
    component: FormPage,
  },
  {
    path: '/catalog/',
    component: CatalogPage,
  },
  {
    path: '/collection/',
    component: CollectionPage,
  },
  {
    path: '/product/:id/',
    component: ProductPage,
  },
  {
    path: '/coin/:id/',
    component: CoinPage,
  },
  {
    path: '/usercoin/:id/',
    component: UserCoinPage,
  },
  {
    path: '/settings/',
    component: SettingsPage,
  },
  {
    path: '/ask/',
    component: AskPage,
  },
  {
    path: '/dynamic-route/blog/:blogId/post/:postId/',
    component: DynamicRoutePage,
  },
  {
    path: '/request-and-load/user/:userId/',
    async: function (routeTo, routeFrom, resolve, reject) {
      // Router instance
      var router = this;

      // App instance
      var app = router.app;

      // Show Preloader
      app.preloader.show();

      // User ID from request
      var userId = routeTo.params.userId;

      // Simulate Ajax Request
      setTimeout(function () {
        // We got user data from request
        var user = {
          firstName: 'Vladimir',
          lastName: 'Kharlampidi',
          about: 'Hello, i am creator of Framework7! Hope you like it!',
          links: [
            {
              title: 'Framework7 Website',
              url: 'http://framework7.io',
            },
            {
              title: 'Framework7 Forum',
              url: 'http://forum.framework7.io',
            },
          ]
        };
        // Hide Preloader
        app.preloader.hide();

        // Resolve route to load page
        resolve(
          {
            component: RequestAndLoad,
          },
          {
            context: {
              user: user,
            }
          }
        );
      }, 1000);
    },
  },
  {
    path: '/faq/:id',
    async: function (routeTo, routeFrom, resolve, reject) {
      var router = this;
      var app = router.app;
      app.preloader.show();
      var userId = routeTo.params.id;

      // Simulate Ajax Request
      setTimeout(function () {
        // We got user data from request
        var post = {
          name: 'Vladimir',
          question: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, neque!', 
          description: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, neque!',
        };
        // Hide Preloader
        app.preloader.hide();

        // Resolve route to load page
        resolve(
          {
            component: faqPage,
          },
          {
            context: {
              post: post,
            }
          }
        );
      }, 500);
    }
  },
  {
    path: '(.*)',
    component: NotFoundPage,
  },
];

export default routes;
