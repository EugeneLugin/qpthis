app.factory('Cities', ['$resource', 'SETTINGS', function($resource, SETTINGS) {
  return $resource(SETTINGS.api_host+'cities/:id');
}]);