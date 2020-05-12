Demo Project for SM

### running 
first create containers:

`docker-compose up -d`

copy sample env file (including db authentication info) :

`cp .env.example .env`

then migrate :

`docker-compose exec php artisan migrate`

you may create jwt secret :

`docker-compose exec php artisan jwt:secret`

and seed the database :

`docker-compose exec php artisan db:seed`


also you may use ```docker-compose exec php artisan import:csv --file=filename``` to import data from csv file


#### front : 
```
:8080
```
#### back : 
```
:80
```
#### product list :
```:80/guest/list```

```:80/guest/list?page=page_num```

```:80/guest/list?category=category_id```

#### swagger: 
remember to run `php artisan l5-swagger:generate` first

```
:80/api/documentation
```
