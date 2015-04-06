app.filter('notags', function(){
  return function(input){
    if(input){
      return input.replace(/<[^>]*>/g, '');
    }
  };
});

app.filter('phone', function(){
  return function(input){
    if(input){
      return '('+input.slice(0,3)+')'+
             input.slice(3,6)+'-'+
             input.slice(6,8)+'-'+
             input.slice(8,10);
    }
  };
});

app.filter('trusted', ['$sce', function($sce){
  return function(text) {
    return $sce.trustAsHtml(text);
  };
}]);

app.filter('reverse', function() {
  return function(items) {
    return items ? items.slice().reverse() : null;
  };
});

app.filter('parseJSON', function() {
  return function(string) {
    res = null;
    try { res = JSON.parse(string); } catch(e) {}
    return res;
  };
});

app.filter('orderFieldName', function() {
    return function(key) {
       return {
          'id': '№',
          'created_at': 'Создан',
          'updated_at': 'Обновлён',
          'alert_at': 'Напомнить',
          'item_id': 'Товар',
          'item_params': 'Параметры товара',
          'item_price': 'Сумма',
          'item_count': 'Кол-во',
          'city_area': 'Город (форма)',
          'address': 'Адрес (форма)',
          'fio': 'ФИО',
          'phone': 'Телефон',
          'phone2': 'Телефон 2',
          'phone3': 'Телефон 3',
          'email': 'Email',
          'newpost_id': 'ТТН',
          'newpost_answer': 'Ответ новой почты',
          'newpost_last_update': 'Обновление новой почты',
          'status_step1': 'Статус шаг 1',
          'status_step2': 'Статус шаг 2',
          'status_step3': 'Статус шаг 3',
          'newpost_backorder': 'ТТН обратной доставки',
          'newpost_backorder_answer': 'Обратная доставка ответ',
          'newpost_last_backorder_update': 'Обновление обратной доставки',
          'comment': 'Комментарий',
          'comment2': 'Комментарий 2',
          'whs_ref': 'Склад Новой почты',
          'weight': 'Вес',
          'width': 'Ширина',
          'length': 'Длина',
          'height': 'Высота',
          'courier_adr': 'Адрес для курьера'
      }[key];
    }
  }
);