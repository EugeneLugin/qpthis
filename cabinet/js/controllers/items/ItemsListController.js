'use strict';

app.controller('ItemsListController',
    [
      'Items',
      '$state',
      '$filter',
      'SETTINGS',
      function (Items, $state, $filter, SETTINGS) {
        var items = this;
        items.list = [];

        items.api_url = SETTINGS.api_host_old;

        Items.query(function(list) {
          items.list = $filter('orderBy')(list, 'inactive');
        });

        items.create_new = function() {
          $state.go('items.create');
        };

        items.delete_it = function(item) {
          item.is_deleted = 1;
          item.$update({id: item.uuid}, function() {
            var index = items.list.indexOf(item);
            items.list.splice(index, 1);
          });
        };

        items.edit = function(item) {
          $state.go('items.one.edit', {uuid: item.uuid});
        };

        items.form_for = function(item) {
          $state.go('items.one.form_for', {uuid: item.uuid});
        };

        items.toggle_active = function(item) {
          item.inactive = item.inactive == 0 ? 1 : 0;
          item.$update({id: item.uuid});
        };
      }
    ]
);
