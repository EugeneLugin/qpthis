'use strict';

app.controller('OrderHistoryController',
    [
      'Orders',
      '$scope',
      '$state',
      '$stateParams',
      function (Orders, $scope, $state, $stateParams) {
        var order = this;

        order.obj = Orders.get({id: $stateParams.id, expand: 'orderAudits'}, function(data) {
        });

        order.back_to_list = function() {
          $state.go('orders.list')
        };
      }
    ]
);
