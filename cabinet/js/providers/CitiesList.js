app.service('CitiesList', ['Cities', '$filter', function(Cities, $filter) {
  var citiesList = this;

  citiesList.list = Cities.query();
}]);
