app.service('ItemsList', ['Items', '$filter', function(Items, $filter) {
  var itemsList = this;

  itemsList.list = Items.query(function(data) {
    return $filter('orderBy')(data, 'name', true);
  });
}]);
