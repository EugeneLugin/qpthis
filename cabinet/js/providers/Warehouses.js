app.factory('Warehouses', ['$resource', 'SETTINGS', function($resource, SETTINGS) {
  return $resource(SETTINGS.api_host+'warehouse/:id');
}]);