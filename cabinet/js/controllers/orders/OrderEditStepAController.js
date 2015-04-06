'use strict';

app.controller('OrderEditStepAController',
    [
      'Orders',
      'StepStatuses',
      '$state',
      '$stateParams',
      function (Orders, StepStatuses, $state, $stateParams) {
        var order = this;

        order.statuses = StepStatuses.stepA;

        order.obj = Orders.get({expand: 'step3', id: $stateParams.id}, function(data) {
          order.obj.status_step3 = data.step3.archive_advise;
        });

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
