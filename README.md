Demo Project for SM

### running 

`docker-compose up -d`

`docker-compose exec php artisan migrate`

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
```
:80/api/documentation
```
