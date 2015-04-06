'use strict';

app.controller('ArchiveListController',
    [
      'Orders',
      '$state',
      '$filter',
      function (Orders, $state, $filter) {
        var orders = this;
        orders.list = [];

        Orders.query({expand: 'item,step1,step2,step3,warehouse', archive: true, r: Date.now()}, function(list) {
          orders.list = $filter('orderBy')(list, ['created_at'], false);
        });

        orders.history = function(order) {
          $state.go('archive.one.history', {id: order.id});
        };
      }
    ]
);
