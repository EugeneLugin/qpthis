app.directive('datetimepicker', [function() {
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {
      console.log(element);
      console.log(attrs);
    }
  };
}]);
