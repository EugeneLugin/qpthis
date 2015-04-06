'use strict';

app.controller('OrdersListController',
    [
      'Orders',
      'ListFilter',
      '$state',
      '$filter',
      '$modal',
      '$scope',
      function (Orders, ListFilter, $state, $filter, $modal, $scope) {
        var orders = this;
        orders.list = [];

        orders.queryList = function() {
          var orders_query = {expand: 'item,step1,step2,step3,warehouse', r: Date.now()};
          angular.extend(orders_query, ListFilter.queryParams());
          Orders.query(orders_query, function(list) {
            orders.list = $filter('orderBy')(list, ['alerted()', 'priority()', 'created_at'], true);
          });
        };
        orders.queryList();

        orders.isCreatedAtFilter = function() {
          return ListFilter.isCreatedAtFilter();
        };
        orders.isStep1Filter = function() {
          return ListFilter.isStep1Filter();
        };
        orders.isStep2Filter = function() {
          return ListFilter.isStep2Filter();
        };
        orders.isStep3Filter = function() {
          return ListFilter.isStep3Filter();
        };
        orders.isItemsFilter = function() {
          return ListFilter.isItemsFilter();
        };

        orders.create_new = function() {
          $state.go('orders.create');
        };

        orders.history = function(order) {
          $state.go('orders.one.history', {id: order.id});
        };
        orders.edit_step1 = function(order) {
          $state.go('orders.one.edit.step1', {id: order.id});
        };
        orders.edit_step2 = function(order) {
          $state.go('orders.one.edit.step2', {id: order.id});
        };
        orders.edit_step3 = function(order) {
          if(!order.step3.archive_possible)
            $state.go('orders.one.edit.step3', {id: order.id});
          else
            $state.go('orders.one.edit.stepA', {id: order.id});
        };
        orders.sms = function(order) {
          $state.go('orders.one.sms', {id: order.id});
        };

        orders.filter_created_at = function() {
          var modalInstance = $modal.open({
            templateUrl: 'views/filters/created_at.html',
            controller: 'FilterCreatedAtController as filter'
          });

          modalInstance.result.then(function () {
          });
        };

        orders.filter_step1 = function() {
          var modalInstance = $modal.open({
            templateUrl: 'views/filters/step1.html',
            controller: 'FilterStep1Controller as filter'
          });

          modalInstance.result.then(function () {
          });
        };
        orders.filter_step2 = function() {
          var modalInstance = $modal.open({
            templateUrl: 'views/filters/step2.html',
            controller: 'FilterStep2Controller as filter'
          });

          modalInstance.result.then(function () {
          });
        };
        orders.filter_step3 = function() {
          var modalInstance = $modal.open({
            templateUrl: 'views/filters/step3.html',
            controller: 'FilterStep3Controller as filter'
          });

          modalInstance.result.then(function () {
          });
        };

        orders.filter_items = function() {
          var modalInstance = $modal.open({
            templateUrl: 'views/filters/item.html',
            controller: 'FilterItemController as filter'
          });

          modalInstance.result.then(function () {
          });
        };

        $scope.$on('ListFilter:update', function() {
          orders.queryList();
        });
      }
    ]
);
