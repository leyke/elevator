# elevator
Тестовое задание Лифты

*Необходимо реализовать функционал для
имитации работы 4х лифтов в 10ти этажном
здании.*

## Работоспособность:
- Расположение лифтов находится в секции Положение;
[![Расположение](https://yadi.sk/i/Oj-hojfo11AbRg "Расположение")](https://yadi.sk/i/Oj-hojfo11AbRg "Расположение")

- Активные заказы лифтов отображены в секции панели управления (лоадер) и В положении (цвет фона);
[![Активные заказы](https://yadi.sk/i/EDjx_wuEUbz4ag "Активные заказы")](https://yadi.sk/i/EDjx_wuEUbz4ag "Активные заказы")

- возможность добавление заказа лифта происходит на панели управления.
[![Заказ лифта](https://yadi.sk/i/0zhEJu09ITv5Cg "Заказ лифта")](https://yadi.sk/i/0zhEJu09ITv5Cg "Заказ лифта")

## Ограничения:
- при первом запуске лифты должны становятся в случайное положение, при последующем запуске положения должны сохраняться с прошлых тестов. **Реализованна функция** `App::init();` **, описанная в классе** *App.php*
- при отсутствии заказов хотя бы один лифт должен находиться на первом этаже;
**Реализуется функцией в script.js** `checkFirstFloor()` **, вызывается каждые 10 сек.**;
- информация о прибывшем лифте описана в секции "[![Последний вызов](https://yadi.sk/i/UPkREVVKl6dI6w "Последний вызов")](https://yadi.sk/i/UPkREVVKl6dI6w "Последний вызов")";
- возможность просмотра логов всех (за всё время) вызовов (в формате: какой лифт на какой этаж сколько раз приехал);
- возможность просмотра логов (за все время) движения лифтов за итерацию (итерация - движения лифта до смены направления, например с 10->7->6->2);
**Статистика посещений и итерации движения лифтов предоставлены в секции [![Статистика](https://yadi.sk/i/uUX29c3jo5ptXA "Статистика")](https://yadi.sk/i/uUX29c3jo5ptXA "Статистика")**

## Допущения:
- состояние лифтов хранится в БД PostgreSQL конфигурация подключения находится в *classes/DataBaseHelper.php*, скрипт для таблицы в *скрипт таблицы.sql*;
- логика реализована на PHP в *index.php* , JS используется для ассинхронной отправки скриптов и обновления данных.
