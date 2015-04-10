'use strict';

app.controller('FilterStep1Controller',
  [ 'ListFilter',
    'StepStatuses',
    '$modalInstance',
    function (ListFilter, StepStatuses, $modalInstance) {
      var filter = this;
      filter.obj = {step1: ListFilter.steps_filter['step1']};
      filter.statuses = StepStatuses.step1;

      filter.submit = function () {
        ListFilter.setStep1Filter(filter.obj.step1);
        $modalInstance.close();
      };
      filter.clear = function () {
        ListFilter.setStep1Filter();
        $modalInstance.close();
      };

      filter.toggleSelection = function(status_id) {
        if (!filter.obj.step1) filter.obj.step1 = [];

        var index = filter.obj.step1.indexOf(status_id);
        if (index === -1)
          filter.obj.step1.push(status_id);
        else
          filter.obj.step1.splice(index, 1);
      };

      filter.cancel = function () {
        $modalInstance.dismiss('cancel');
      };
    }
  ]
);
