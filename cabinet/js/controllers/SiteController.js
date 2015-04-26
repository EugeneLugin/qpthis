'use strict';

app.controller('SiteController',
    [
      'Orders',
      '$scope',
      '$state',
      '$interval',
      function (Orders, $scope, $state, $interval) {
        $scope.$state = $state;

        var site = this;

        site.new_orders_count = null;

        site.get_new_counters = function() {
          Orders.counters(function (counter) {
            site.new_orders_count = counter.count;
          });
        };

        $interval(function() {
          site.get_new_counters();
        }, 15000);

        site.get_new_counters();
      }
    ]
);
