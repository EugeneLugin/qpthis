app.factory('Statuses', ['$resource', 'SETTINGS', function($resource, SETTINGS) {
  return $resource(SETTINGS.api_host+'status/:id')
}]);