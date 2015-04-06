app.factory('Items', ['$resource', 'SETTINGS', function($resource, SETTINGS) {
  return $resource(SETTINGS.api_host+'item/:id', {
    id: '@_id'
  }, {
    update: {
      method: 'PUT'
    }
  })
}]);