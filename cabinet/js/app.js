'use strict';

var app = angular.module('qpthis',
    [
      'ui.router',
      'ui.bootstrap',
      'ui.mask',
      'ui.tinymce',
      'ngResource'
    ]
);

app.config(function($stateProvider, $urlRouterProvider) {
  $urlRouterProvider.otherwise("/orders");

  var items = {
    name: 'items',
    url: "/items",
    abstract: true,
    template: '<ui-view />'
  };
  var items_list = {
    name: 'items.list',
    parent: items,
    url: "",
    templateUrl: "views/items/list.html",
    controller: "ItemsListController as items"
  };
  var item_create = {
    name: 'items.create',
    parent: items,
    url: "/create",
    templateUrl: "views/items/create.html",
    controller: "ItemCreateController as item"
  };
  var item_one = {
    name: 'items.one',
    parent: items,
    abstract: true,
    url: '/:uuid',
    template: '<ui-view />'
  };
  var item_edit = {
    name: 'items.one.edit',
    parent: item_one,
    url: '/edit',
    templateUrl: "views/items/edit.html",
    controller: "ItemEditController as item"
  };
  var item_form_for = {
    name: 'items.one.form_for',
    parent: item_one,
    url: '/form_for',
    templateUrl: "views/items/form_for.html",
    controller: "ItemFormForController as item"
  };

  var orders = {
    name: 'orders',
    url: "/orders",
    abstract: true,
    template: '<ui-view />'
  };
  var orders_create = {
    name: 'orders.create',
    parent: orders,
    url: "/create",
    templateUrl: "views/orders/create.html",
    controller: "OrderCreateController as order"
  };
  var orders_list = {
    name: 'orders.list',
    parent: orders,
    url: "",
    templateUrl: "views/orders/list.html",
    controller: "OrdersListController as orders"
  };
  var orders_one = {
    name: 'orders.one',
    parent: orders,
    abstract: true,
    url: '/:id',
    template: '<ui-view />'
  };
  var order_history = {
    parent: orders_one,
    name: 'orders.one.history',
    url: '/history',
    templateUrl: "views/orders/history.html",
    controller: "OrderHistoryController as order"
  };
  var order_edit = {
    parent: orders_one,
    name: 'orders.one.edit',
    url: '/edit',
    abstract: true,
    template: '<ui-view />'
  };
  var order_edit_step1 = {
    parent: orders_one,
    name: 'orders.one.edit.step1',
    url: '/step1',
    templateUrl: "views/orders/edit_step1.html",
    controller: "OrderEditStep1Controller as order"
  };
  var order_edit_step2 = {
    parent: orders_one,
    name: 'orders.one.edit.step2',
    url: '/step1',
    templateUrl: "views/orders/edit_step2.html",
    controller: "OrderEditStep2Controller as order"
  };
  var order_edit_step3 = {
    parent: orders_one,
    name: 'orders.one.edit.step3',
    url: '/step3',
    templateUrl: "views/orders/edit_step3.html",
    controller: "OrderEditStep3Controller as order"
  };
  var order_edit_stepA = {
    parent: orders_one,
    name: 'orders.one.edit.stepA',
    url: '/stepA',
    templateUrl: "views/orders/edit_stepA.html",
    controller: "OrderEditStepAController as order"
  };
  var order_sms = {
    parent: orders_one,
    name: 'orders.one.sms',
    url: '/sms',
    templateUrl: "views/orders/sms.html",
    controller: "OrderSmsController as order"
  };

  var archive = {
    name: 'archive',
    url: "/archive",
    abstract: true,
    template: '<ui-view />'
  };
  var archive_list = {
    name: 'archive.list',
    parent: archive,
    url: "",
    templateUrl: "views/archive/list.html",
    controller: "ArchiveListController as orders"
  };
  var archive_one = {
    name: 'archive.one',
    abstract: true,
    url: '/:id',
    template: '<ui-view />'
  };
  var archive_history = {
    name: 'archive.one.history',
    url: '/history',
    templateUrl: "views/orders/history.html",
    controller: "OrderHistoryController as order"
  };

  var newpostlist = {
    name: 'newpostlist',
    url: '/newpost_list',
    templateUrl: 'views/newpost_list.html',
    controller: "NewpostListController as np_list"
  };

  $stateProvider
      .state(orders)
      .state(orders_create)
      .state(orders_list)
      .state(orders_one)
      .state(order_history)
      .state(order_edit)
      .state(order_edit_step1)
      .state(order_edit_step2)
      .state(order_edit_step3)
      .state(order_edit_stepA)
      .state(order_sms)

      .state(archive)
      .state(archive_list)
      .state(archive_one)
      .state(archive_history)

      .state(items)
      .state(items_list)
      .state(item_create)
      .state(item_one)
      .state(item_edit)
      .state(item_form_for)

      .state(newpostlist)
});

