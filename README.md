
Usergems - Calendar Email Ticket
=====
# Prerequisites
- Install **Docker**

# Introduction

Be sure that the following ports are available:
* :8080
* :5432
* :6379

The horizon app could be found on https://localhost:8080/horizon

An example of the output could be found on file **example.json** for user **stephan@usergems.com**

# Prepare the app

## Build and run the container
```sh
    docker-compose build --no-cache // to build the image
    docker-compose up --remove-orphans // this automatically install the composer dependecies and run the container
    
    php artisan migrate:fresh --seed //run inside the container to create tables and seed data
```

## Run the CalendarEvents Command
```sh
    php artisan app:calendar-events // this should be run inside the container if you want manually to trigger it
```



For any questions please reach me out on andreic.dev@gmail.com
