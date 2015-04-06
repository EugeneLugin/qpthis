'use strict';

app.controller('ItemFormForController',
    [
      'Items',
      '$state',
      '$stateParams',
      function (Items, $state, $stateParams) {
        var item = this;

        var defaultObj = {};

        item.obj = Items.get({id: $stateParams.uuid}, function(data) {
            defaultObj = data;
        });

        item.back_to_list = function() {
          $state.go('items.list')
        };
      }
    ]
);
