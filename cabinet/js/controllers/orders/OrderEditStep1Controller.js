'use strict';

app.controller('OrderEditStep1Controller',
    [
      'Orders',
      'StepStatuses',
      'Cities',
      'CitiesList',
      'Warehouses',
      '$scope',
      '$state',
      '$stateParams',
      function (Orders, StepStatuses, Cities, CitiesList, Warehouses, $scope, $state, $stateParams) {
        var order = this;

        order.statuses = StepStatuses.step1;
        order.cities = CitiesList.list;
        order.selected_city = null;

        order.city_ref = '';

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

        order.obj = Orders.get({id: $stateParams.id, expand: 'item,warehouse,orderAudits'}, function(data) {
          if (data.warehouse) {
            order.city_ref = data.warehouse.city_ref;
            order.selected_city = Cities.get({id: order.city_ref, expand: 'warehouses'});
          }
          if (!data.weight) data.weight = data.item.weight;
          if (!data.length) data.length = data.item.length;
          if (!data.height) data.height = data.item.height;
          if (!data.width) data.width = data.item.width;

          if (!data.whs_ref && data.city_area) {
            Cities.query({q: data.city_area.trim().split(' ')[0], expand: 'warehouses'}, function(list) {
              if (list && list.length > 0) {
                order.selected_city = list[0];
                order.city_ref = order.selected_city.ref;
                var s_number = data.address.match(/\d+/);
                if (s_number) {
                  order.selected_city.warehouses.forEach(function (whs) {
                    if (+whs.number == +s_number[0]) {
                      order.obj.whs_ref = whs.ref;
                    }
                  });
                }
              }
            });
          }
        });

        order.changeCity = function() {
          if(order.city_ref != '') {
            order.selected_city = Cities.get({id: order.city_ref, expand: 'warehouses'}, function(city) {
                // order.warehouse_ref = city.wharehouses[0].ref; // TODO: fix
            });
          }
        };

        order.back_to_list = function() {
          $state.go('orders.list')
        };

        order.submit = function () {
          if ( [110,111,112,114,115].indexOf(order.obj.status_step1) != -1 ) {
            order.obj.alert_at = null;
          }
          order.obj.$update({id: order.obj.id}, function() {
            $state.go('orders.list');
          }, function(errors) {
            console.log('error', errors);
          });
        };
      }
    ]
);
