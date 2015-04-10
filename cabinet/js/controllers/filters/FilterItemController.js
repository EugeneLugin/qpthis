'use strict';

app.controller('FilterItemController',
  [ 'ListFilter',
    'ItemsList',
    '$modalInstance',
    function (ListFilter, ItemsList, $modalInstance) {
      var filter = this;
      filter.obj = {items: ListFilter.items_filter['items[]']};
      filter.items = ItemsList.list;

      filter.submit = function () {
        ListFilter.setItemsFilter(filter.obj.items);
        $modalInstance.close();
      };
      filter.clear = function () {
        ListFilter.setItemsFilter();
        $modalInstance.close();
      };

      filter.toggleSelection = function(item_uuid) {
        if (!filter.obj.items) filter.obj.items = [];

        var index = filter.obj.items.indexOf(item_uuid);
        if (index === -1)
          filter.obj.items.push(item_uuid);
        else
          filter.obj.items.splice(index, 1);
      };

      filter.cancel = function () {
        $modalInstance.dismiss('cancel');
      };
    }
  ]
);
