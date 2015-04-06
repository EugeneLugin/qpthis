app.service('StepStatuses', ['Statuses', '$filter', '$q', function(Statuses, $filter, $q) {
  var stepStatuses = this;

  stepStatuses.step1 = Statuses.query({step1:1});
  stepStatuses.step2 = Statuses.query({step2:1});
  stepStatuses.step3 = Statuses.query({step3:1});
  stepStatuses.stepA = Statuses.query({stepA:1});

  stepStatuses.find_step1 = function(id) {
    var deffered = $q.defer();
    stepStatuses.step1.$promise.then(function(data) {
      deffered.resolve($filter('filter')(data, {id: id}));
    });
    return deffered.promise;
  };

  stepStatuses.find_step2 = function(id) {
    var deffered = $q.defer();
    stepStatuses.step2.$promise.then(function(data) {
      deffered.resolve($filter('filter')(data, {id: id}));
    });
    return deffered.promise;
  };

  stepStatuses.find_step3 = function(id) {
    var deffered = $q.defer();
    stepStatuses.step3.$promise.then(function(data) {
      deffered.resolve($filter('filter')(data, {id: id}));
    });
    return deffered.promise;
  };

  stepStatuses.find = function(id) {
    var deffered = $q.defer();
    stepStatuses.find_step1(id).then(function(data){
      if (data && data.length>0) { deffered.resolve(data); }
      else {
        stepStatuses.find_step2(id).then(function (data2) {
          if (data2 && data2.length>0) {
            deffered.resolve(data2);
          }
          else {
            stepStatuses.find_step3(id).then(function (data3) {
              if (data3 && data3.length>0) {
                deffered.resolve(data3);
              }
            });
          }
        });
      }
    });
    return deffered.promise;
  };
}]);
