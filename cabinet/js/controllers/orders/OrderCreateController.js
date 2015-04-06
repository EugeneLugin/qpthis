'use strict';

app.controller('OrderCreateController',
    [
      'Orders',
      '$state',
      function (Orders, $state) {
        var order = this;

        var defaultObj = new Orders();

        order.obj = defaultObj;

        order.reset = function() {
          order.obj = defaultObj;
        };

        order.back_to_list = function() {
          $state.go('orders.list')
        };

        order.submit = function () {
          order.obj.$save(function() {
            $state.go('orders.list');
          }, function(errors) {
            console.log('error', errors);
          });
        };
      }
    ]
);
