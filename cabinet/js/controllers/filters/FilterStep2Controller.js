'use strict';

app.controller('FilterStep2Controller',
  [ 'ListFilter',
    'StepStatuses',
    '$modalInstance',
    function (ListFilter, StepStatuses, $modalInstance) {
      var filter = this;
      filter.obj = {step2: ListFilter.steps_filter['step2']};
      filter.statuses = StepStatuses.step2;

      filter.submit = function () {
        ListFilter.setStep2Filter(filter.obj.step2);
        $modalInstance.close();
      };
      filter.clear = function () {
        ListFilter.setStep2Filter();
        $modalInstance.close();
      };

      filter.toggleSelection = function(status_id) {
        if (!filter.obj.step2) filter.obj.step2 = [];

        var index = filter.obj.step2.indexOf(status_id);
        if (index === -1)
          filter.obj.step2.push(status_id);
        else
          filter.obj.step2.splice(index, 1);
      };

      filter.cancel = function () {
        $modalInstance.dismiss('cancel');
      };
    }
  ]
);
