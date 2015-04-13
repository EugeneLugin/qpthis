app.service('ListFilter', ['$rootScope', function($rootScope) {
  var ListFilter = this;

  ListFilter.created_at_filter = {date_from: null, date_till: null};
  ListFilter.steps_filter = {'step1[]': null, 'step2[]': null, 'step3[]': null};
  ListFilter.items_filter = {'items[]': null};

  ListFilter.loadFromStorage = function() {
    try {
      angular.extend(ListFilter, JSON.parse(localStorage.getItem('ListFilter')));
    } catch (e) {}
  }();

  ListFilter.saveInLocalStorage = function() {
    try {
      localStorage.setItem('ListFilter', JSON.stringify(ListFilter));
      $rootScope.$broadcast('ListFilter:update');
    } catch(e) {}
  };

  ListFilter.isCreatedAtFilter = function() {
    return ListFilter.created_at_filter.date_from || ListFilter.created_at_filter.date_till;
  };

  ListFilter.isStep1Filter = function() {
    return !!ListFilter.steps_filter['step1[]'];
  };
  ListFilter.isStep2Filter = function() {
    return !!ListFilter.steps_filter['step2[]'];
  };
  ListFilter.isStep3Filter = function() {
    return !!ListFilter.steps_filter['step3[]'];
  };
  ListFilter.isItemsFilter = function() {
    return !!ListFilter.items_filter['items[]'];
  };

  ListFilter.setCreatedAtFilter = function(filter) {
    ListFilter.created_at_filter = filter;
    ListFilter.saveInLocalStorage();
  };

  ListFilter.setStep1Filter = function(filter) {
    ListFilter.steps_filter['step1[]'] = filter;
    ListFilter.saveInLocalStorage();
  };
  ListFilter.setStep2Filter = function(filter) {
    ListFilter.steps_filter['step2[]'] = filter;
    ListFilter.saveInLocalStorage();
  };
  ListFilter.setStep3Filter = function(filter) {
    ListFilter.steps_filter['step3[]'] = filter;
    ListFilter.saveInLocalStorage();
  };
  ListFilter.setItemsFilter = function(filter) {
    ListFilter.items_filter['items[]'] = filter;
    ListFilter.saveInLocalStorage();
  };

  ListFilter.queryParams = function() {
    var res = {};
    return angular.extend(res, ListFilter.created_at_filter, ListFilter.steps_filter, ListFilter.items_filter);
  };
}]);

