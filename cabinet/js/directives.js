app.directive('inputField', function() {
  return {
    restrict: 'E',
    templateUrl: 'views/directives/inputField.html',
    scope: {
      type: '@',
      step: '@',
      min: '@',
      title: '@',
      name: '@',
      readonly: '@',
      required: '@',
      model: '='
    }
  };
});

app.directive('historyBlock', ['$filter', function($filter) {
  return {
    restrict: 'E',
    templateUrl: 'views/directives/historyBlock.html',
    scope: {
      obj: '='
    },
    link: function(scope) {
      scope.obj = $filter('parseJSON')(scope.obj);
    }
  };
}]);

app.directive('newpostWarehouse', ['Warehouses', function(Warehouses) {
  return {
    restrict: 'E',
    template: '<span ng-if="whs">{{whs.cityRu}}, {{whs.addressRu}}</span>',
    scope: {
      whsref: '='
    },
    link: function(scope) {
      if(scope.whsref) {
        scope.whs = Warehouses.get({id: scope.whsref}, function (data) {
        });
      }
    }
  };
}]);

app.directive('itemName', ['Items', function(Items) {
  return {
    restrict: 'E',
    template: '<span ng-if="item">{{item.name}}</span>',
    scope: {
      uuid: '='
    },
    link: function(scope) {
      if(scope.uuid) {
        scope.item = Items.get({id: scope.uuid}, function (data) {
        });
      }
    }
  };
}]);

app.directive('stepStatus', ['StepStatuses', function(StepStatuses) {
  return {
    restrict: 'E',
    template: '<span ng-if="status">{{status.name | notags}}</span>',
    scope: {
      stid: '='
    },
    link: function(scope) {
      if(scope.stid) {
        scope.status = StepStatuses.find(scope.stid).then(function(data){
          scope.status = data[0];
        });
      }
    }
  };
}]);
