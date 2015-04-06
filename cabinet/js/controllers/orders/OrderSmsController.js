'use strict';

app.controller('OrderSmsController',
    [
      'Orders',
      '$state',
      '$stateParams',
      function (Orders, $state, $stateParams) {
        var order = this;

        order.obj = Orders.get({id: $stateParams.id, expand: 'step2,flysms'}, function(data) {
          //console.log(data);
        });

        order.back_to_list = function() {
          $state.go('orders.list')
        };

        order.submit = function () {

        };
      }
    ]
);
