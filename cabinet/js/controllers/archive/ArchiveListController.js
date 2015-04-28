'use strict';

app.controller('ArchiveListController',
    [
      '$state',
      '$filter',
      '$modal',
      '$scope',
      'Orders',
      'ListFilter',
      function ($state, $filter, $modal, $scope, Orders, ListFilter) {
        var orders = this;
        orders.list = [];

        orders.queryList = function() {
          var orders_query = {expand: 'item,step1,step2,step3,warehouse', archive: true, r: Date.now()};
          angular.extend(orders_query, ListFilter.queryParams());
          Orders.query(orders_query, function (list) {
            orders.list = $filter('orderBy')(list, ['created_at'], true);
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

        orders.history = function(order) {
          $state.go('archive.one.history', {id: order.id});
        };

        $scope.$on('ListFilter:update', function() {
          orders.queryList();
        });
      }
    ]
);
