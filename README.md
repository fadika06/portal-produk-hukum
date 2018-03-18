# ProdukHukum

[![Join the chat at https://gitter.im/produk-hukum/Lobby](https://badges.gitter.im/produk-hukum/Lobby.svg)](https://gitter.im/produk-hukum/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/produk-hukum/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/produk-hukum/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/produk-hukum/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/produk-hukum/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/produk-hukum/v/stable)](https://packagist.org/packages/bantenprov/produk-hukum)
[![Total Downloads](https://poser.pugx.org/bantenprov/produk-hukum/downloads)](https://packagist.org/packages/bantenprov/produk-hukum)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/produk-hukum/v/unstable)](https://packagist.org/packages/bantenprov/produk-hukum)
[![License](https://poser.pugx.org/bantenprov/produk-hukum/license)](https://packagist.org/packages/bantenprov/produk-hukum)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/produk-hukum/d/monthly)](https://packagist.org/packages/bantenprov/produk-hukum)
[![Daily Downloads](https://poser.pugx.org/bantenprov/produk-hukum/d/daily)](https://packagist.org/packages/bantenprov/produk-hukum)

ProdukHukum

### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/produk-hukum:dev-master
```

- Latest release:

```bash
$ composer require bantenprov/produk-hukum
```

### Download via github

```bash
$ git clone https://github.com/bantenprov/produk-hukum.git
```

#### Edit `config/app.php` :

```php
'providers' => [

    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //....
    Bantenprov\ProdukHukum\ProdukHukumServiceProvider::class,
```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Publish database seeder :

```bash
$ php artisan vendor:publish --tag=produk-hukum-seeds
```

#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan seeding :

```bash
$ php artisan db:seed --class=BantenprovProdukHukumSeeder
```

#### Lakukan publish component vue :

```bash
$ php artisan vendor:publish --tag=produk-hukum-assets
$ php artisan vendor:publish --tag=produk-hukum-public
```
#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
         path: '/dashboard/produk-hukum',
         components: {
            main: resolve => require(['./components/views/bantenprov/produk-hukum/DashboardProdukHukum.vue'], resolve),
            navbar: resolve => require(['./components/Navbar.vue'], resolve),
            sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
          },
          meta: {
            title: "ProdukHukum"
           }
       },
        //== ...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
            path: '/admin/produk-hukum',
            components: {
                main: resolve => require(['./components/bantenprov/produk-hukum/ProdukHukum.index.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "ProdukHukum"
            }
        },
        {
            path: '/admin/produk-hukum/create',
            components: {
                main: resolve => require(['./components/bantenprov/produk-hukum/ProdukHukum.add.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add ProdukHukum"
            }
        },
        {
            path: '/admin/produk-hukum/:id',
            components: {
                main: resolve => require(['./components/bantenprov/produk-hukum/ProdukHukum.show.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View ProdukHukum"
            }
        },
        {
            path: '/admin/produk-hukum/:id/edit',
            components: {
                main: resolve => require(['./components/bantenprov/produk-hukum/ProdukHukum.edit.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit ProdukHukum"
            }
        },
        //== ...
    ]
},
```
#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //== ...
        {
        name: 'ProdukHukum',
        link: '/dashboard/produk-hukum',
        icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //== ...
        {
        name: 'ProdukHukum',
        link: '/admin/produk-hukum',
        icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//== ProdukHukum

import ProdukHukum from './components/bantenprov/produk-hukum/ProdukHukum.chart.vue';
Vue.component('echarts-produk-hukum', ProdukHukum);

import ProdukHukumKota from './components/bantenprov/produk-hukum/ProdukHukumKota.chart.vue';
Vue.component('echarts-produk-hukum-kota', ProdukHukumKota);

import ProdukHukumTahun from './components/bantenprov/produk-hukum/ProdukHukumTahun.chart.vue';
Vue.component('echarts-produk-hukum-tahun', ProdukHukumTahun);

import ProdukHukumAdminShow from './components/bantenprov/produk-hukum/ProdukHukumAdmin.show.vue';
Vue.component('admin-view-produk-hukum-tahun', ProdukHukumAdminShow);

//== Echarts Group Egoverment

import ProdukHukumBar01 from './components/views/bantenprov/produk-hukum/ProdukHukumBar01.vue';
Vue.component('produk-hukum-bar-01', ProdukHukumBar01);

import ProdukHukumBar02 from './components/views/bantenprov/produk-hukum/ProdukHukumBar02.vue';
Vue.component('produk-hukum-bar-02', ProdukHukumBar02);

//== mini bar charts
import ProdukHukumBar03 from './components/views/bantenprov/produk-hukum/ProdukHukumBar03.vue';
Vue.component('produk-hukum-bar-03', ProdukHukumBar03);

import ProdukHukumPie01 from './components/views/bantenprov/produk-hukum/ProdukHukumPie01.vue';
Vue.component('produk-hukum-pie-01', ProdukHukumPie01);

import ProdukHukumPie02 from './components/views/bantenprov/produk-hukum/ProdukHukumPie02.vue';
Vue.component('produk-hukum-pie-02', ProdukHukumPie02);

//== mini pie charts


import ProdukHukumPie03 from './components/views/bantenprov/produk-hukum/ProdukHukumPie03.vue';
Vue.component('produk-hukum-pie-03', ProdukHukumPie03);

```

