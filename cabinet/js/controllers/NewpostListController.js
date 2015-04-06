'use strict';

app.controller('NewpostListController',
    [
      'Orders',
      '$state',
      '$filter',
      '$timeout',
      function (Orders, $state, $filter, $timeout) {
        var np_list = this;
        np_list.list = [];

        np_list.list = Orders.query({expand: 'item,warehouse', newpostlist: true}, function(list) {
        });

        np_list.done = function() {
          np_list.list.forEach(function(order) {
            order.status_step2 = 200;
            order.alert_at = $filter('date')(Date.now(), 'yyyy-MM-dd HH:mm:ss');
            order.$update({id: order.id});
          });
          $timeout(function() {
            $state.go('orders.list');
          }, 500);
        }
      }
    ]
);
