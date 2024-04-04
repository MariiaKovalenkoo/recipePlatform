# Recipe Platform

This repository contains a docker configuration with:
* NGINX webserver
* PHP FastCGI Process Manager with PDO MySQL support
* MariaDB (GPL MySQL fork)
* PHPMyAdmin

## Login data for user accounts
username and password:
* user1, password1
* user2, password2
* user3, password3
* user4, password4

## Usage

In a terminal, run:
```bash
docker-compose up
```

NGINX will now serve files in the app/public folder. Visit localhost in your browser to check.
PHPMyAdmin is accessible on localhost:8080

If you want to stop the containers, press Ctrl+C.
Or run:
```bash
docker-compose down
```
