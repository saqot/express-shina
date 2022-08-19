# Тестовое задание Express-шина
Реализация бэкенд API под список товаров и управление корзиной пользователя

- [Вакания](https://rubtsovsk.hh.ru/vacancy/68152473)
- [Само ТЗ](https://docs.google.com/document/d/1FrSQ_Z6e4klg_1WV64OwO3MM7YxzjVLCBfIhVcoRBPo)

# Установка
* Выполнить команды\
  `git clone git@github.com:saqot/express-shina.git`\
  `php composer install`
* Создать базу и настроить к ней подключение на базе .env файла
* Выполнить команды\
  `php bin/console doctrine:migrations:migrate`\
  `php bin/console doctrine:fixtures:load`

# Для тестов
* Создать базу суффиксом **_test**
* Выполнить команды\
  `php bin/console doctrine:migrations:migrate --env test`\
  `php bin/phpunit`

##### - - - - - -
* Т.к. в ТЗ не было сказани ничего про цены товаров, то цена является рендомом в моменте добавления товара в корзину.
* Т.к. в ТЗ не было уточнений по списку товаров корзины, то список был сделан полный со всей иерархией
* Времени не хватило покрыть полноценно тестами логику корзины, поэтому пара основных только
* Если будут вопросы или уточнения - с удовольствием отвечу.