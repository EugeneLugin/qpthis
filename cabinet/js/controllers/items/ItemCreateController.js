'use strict';

app.controller('ItemCreateController',
    [
      'Items',
      '$state',
      function (Items, $state) {
        var item = this;

        var defaultObj = new Items({
          uuid: 'xxxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
            return v.toString(16);
          }),
          name: '',
          short_name: '',
          url: 'http://',
          price: 99,
          weight: 0.1,
          width: 10,
          height: 10,
          length: 10,
          yandexmetric: '',
          yandexgoal: '',
          yandexgoal2: '',
          param1_name: '',
          param1: '',
          param2_name: '',
          param2: '',
          is_deleted: 0,
          inactive: 0
        });

        item.obj = defaultObj;

        item.tinymceOptions = {
          plugins: "code",
          toolbar: "undo redo formatselect bold italic justifyleft justifycenter justifyright justifyfull bullist numlist outdent indent code"
        };
        
        item.reset = function() {
          item.obj = defaultObj;
        };

        item.back_to_list = function() {
          $state.go('items.list')
        };

        item.submit = function () {
          item.obj.$save(function() {
            $state.go('items.list');
          }, function(errors) {
            console.log('error', errors);
          });
        };
      }
    ]
);
