Копируем репозиторий\
git clone https://github.com/yuri-yamsh/books.git

Устанавливаем зависимости\
composer install

Запускаем виртуальное окружение\
cd booksdocker &&
docker-compose up -d nginx postgres && cd ../

Создаем базу данных и заполняем ее тестовыми данными\
php bin/console doctrine:database:create\
php bin/console doctrine:migrations:migrate\
php bin/console doctrine:fixtures:load\

Для запуска тестов\
bin/phpunit

php bin/console doctrine:database:create --env=test\
php bin/console doctrine:migrations:migrate --env=test

Методы api\
POST /api/book/create ['name', 'author']\
GET /api/{lang}/book/{id}\
GET /api/book/search?name= ['name']\
POST /api/author/create ['name']\
