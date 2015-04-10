'use strict';

app.controller('FilterStep3Controller',
  [ 'ListFilter',
    'StepStatuses',
    '$modalInstance',
    function (ListFilter, StepStatuses, $modalInstance) {
      var filter = this;
      filter.obj = {step3: ListFilter.steps_filter['step3']};
      filter.statuses = StepStatuses.step3;

      filter.submit = function () {
        ListFilter.setStep3Filter(filter.obj.step3);
        $modalInstance.close();
      };
      filter.clear = function () {
        ListFilter.setStep3Filter();
        $modalInstance.close();
      };

      filter.toggleSelection = function(status_id) {
        if (!filter.obj.step3) filter.obj.step3 = [];

        var index = filter.obj.step3.indexOf(status_id);
        if (index === -1)
          filter.obj.step3.push(status_id);
        else
          filter.obj.step3.splice(index, 1);
      };

      filter.cancel = function () {
        $modalInstance.dismiss('cancel');
      };
    }
  ]
);
