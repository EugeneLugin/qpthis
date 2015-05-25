'use strict';

app.controller('ItemEditController',
    [
      'Items',
      '$state',
      '$stateParams',
      function (Items, $state, $stateParams) {
        var item = this;

        var defaultObj = {};

        item.tinymceOptions = {
          plugins: "code",
          toolbar: "undo redo formatselect bold italic justifyleft justifycenter justifyright justifyfull bullist numlist outdent indent code"
        };

        item.obj = Items.get({id: $stateParams.uuid}, function(data) {
            defaultObj = data;
        });

        item.reset = function() {
          item.obj = defaultObj;
        };

        item.back_to_list = function() {
          $state.go('items.list')
        };

        item.submit = function () {
          item.obj.$update({id: item.obj.uuid}, function() {
            $state.go('items.list');
          }, function(errors) {
            console.log('error', errors);
          });
        };
      }
    ]
);
