Тестовое задание VRG Soft
Для локальной установки на свой компьютер:

1) Cклонируйте репозиторий
(git clone https://github.com/jon1267/vrg_soft.git , либо архивом)
2) composer install
3) Создайте MySQL базу данных (наверное все будет работать и при sqlite, не пробовал)
4) Создайте файл .env (скопируйте файл .env.example в .env)
5) В файле .env подключите базу данных
6) Также поменял настройку APP_URL=http://localhost шедшую по умолчанию, на следующую:
   APP_URL=https://vrgajax.loc - мой локальный домен, для отображения картинок
6) npm install && npm run dev
7) php artisan migrate
8) php artisan key:generate
8) Нужно создать символическую ссылку: php artisan storage:link , для работы изображений
9) Все готово для запуска. первый экран Ларавел 12 изменен.
Добавлены ссылки /authors, /books чтоб кликать мышой, а не набирать руками.
