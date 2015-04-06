'use strict';

app.controller('OrderEditStep2Controller',
    [
      'Orders',
      'StepStatuses',
      '$state',
      '$stateParams',
      function (Orders, StepStatuses, $state, $stateParams) {
        var order = this;

        order.statuses = StepStatuses.step2;
        order.obj = Orders.get({id: $stateParams.id, expand: 'step2,orderAudits'}, function(data) {
        });

        $('#inputalert_at').datetimepicker({
          format: 'yyyy-mm-dd hh:ii',
          autoclose: true,
          todayBtn: true,
          startView: 1,
          language: 'ru',
          weekStart: 1
        }).on('change', function() {
          order.obj.alert_at = $('#inputalert_at').val();
        });

        order.back_to_list = function() {
          $state.go('orders.list')
        };

        order.submit = function () {
          if (order.obj.status_step2 == 200 && order.obj.newpost_id) order.obj.alert_at = null;
          order.obj.$update({id: order.obj.id}, function() {
            $state.go('orders.list');
          }, function(errors) {
            console.log('error', errors);
          });
        };
      }
    ]
);
