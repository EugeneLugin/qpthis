app.factory('Orders', ['$resource', 'SETTINGS', function($resource, SETTINGS) {
  var Order = $resource(SETTINGS.api_host+'order/:id', {
    id: '@_id'
  }, {
    counters: {
      url: SETTINGS.api_host+'order/counters',
      method: 'GET',
      isArray: false
    },
    update: {
      method: 'PUT'
    }
  });

  Order.prototype.alerted = function() {
    return Date.parse(this.alert_at) < Date.now();
  };

  Order.prototype.priority = function() {
    return this.step3.priority || this.step2.priority || this.step1.priority;
  };

  Order.prototype.get_newpost_answer = function() {
    if (!this.parsed_newpost_answer && this.newpost_answer && !(this.newpost_answer == '')) {
      this.parsed_newpost_answer = JSON.parse(this.newpost_answer);
    }
    if (this.parsed_newpost_answer)
      return this.parsed_newpost_answer;
    else
      return {};
  };

  Order.prototype.get_newpost_backorder_answer = function() {
    if (!this.parsed_newpost_backorder_answer && this.newpost_backorder_answer && !(this.newpost_backorder_answer == '')) {
      this.parsed_newpost_backorder_answer = JSON.parse(this.newpost_backorder_answer);
    }
    if (this.parsed_newpost_backorder_answer)
      return this.parsed_newpost_backorder_answer;
    else
      return {};
  };

  return Order;
}]);