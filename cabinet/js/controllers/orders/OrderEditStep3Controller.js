'use strict';

app.controller('OrderEditStep3Controller',
    [
      'Orders',
      'StepStatuses',
      '$state',
      '$stateParams',
      function (Orders, StepStatuses, $state, $stateParams) {
        var order = this;

        order.statuses = StepStatuses.stepA;

        order.obj = Orders.get({id: $stateParams.id, expand: 'orderAudits'}, function(data) {});

        order.back_to_list = function() {
          $state.go('orders.list')
        };

        order.submit = function () {
          order.obj.$update({id: order.obj.id}, function() {
            $state.go('orders.list');
          }, function(errors) {
            console.log('error', errors);
          });
        };

        order.clearStep3 = function() {
          order.obj.status_step3 = 0;
          order.submit();
        }
      }
    ]
);
