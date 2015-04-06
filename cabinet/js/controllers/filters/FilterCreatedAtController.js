'use strict';

app.controller('FilterCreatedAtController',
  [ 'ListFilter',
    '$modalInstance',
    '$timeout',
    function (ListFilter, $modalInstance, $timeout) {
      var filter = this;
      filter.obj = {date_from: ListFilter.created_at_filter.date_from,
                    date_till: ListFilter.created_at_filter.date_till};

      $timeout(function() {
        $('#date_from').datetimepicker({
          format: 'yyyy-mm-dd hh:ii',
          autoclose: true,
          todayBtn: true,
          startView: 2,
          language: 'ru',
          weekStart: 1
        }).on('change', function () {
          filter.obj.date_from = $('#date_from').val();
        });

        $('#date_till').datetimepicker({
          format: 'yyyy-mm-dd hh:ii',
          autoclose: true,
          todayBtn: true,
          startView: 2,
          language: 'ru',
          weekStart: 1
        }).on('change', function () {
          filter.obj.date_till = $('#date_till').val();
        });
      }, 1);

      filter.submit = function () {
        ListFilter.setCreatedAtFilter({date_from: filter.obj.date_from, date_till: filter.obj.date_till});
        $modalInstance.close();
      };
      filter.clear = function () {
        ListFilter.setCreatedAtFilter({date_from: null, date_till: null});
        $modalInstance.close();
      };

      filter.cancel = function () {
        $modalInstance.dismiss('cancel');
      };
    }
  ]
);
