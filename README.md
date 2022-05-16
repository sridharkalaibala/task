REST API TASK
======================================

Requirements
------------

- Docker


Installation
------------

### prerequisites

Make sure you have Docker installed and set enough max_map_count

Ex. Windows: [Powershell with Admin mode]

```bash
$ wsl -d docker-desktop
$ sysctl -w vm.max_map_count=262144
```

Mac & Linux Visit: https://www.elastic.co/guide/en/elasticsearch/reference/current/docker.html#_macos_with_docker_for_mac


### Run Project via Docker


```bash
$ git clone git@github.com:sridharkalaibala/task.git
$ cd task
$ docker-compose build
# Install dependencies via composer, if you haven't already:
$ docker-compose run api composer install
# Enable development mode:
$ docker-compose run api composer development-enable
```

Start the container:

```bash
$ docker-compose up
```

### Project URL

now you can access swagger API documentation via:

###API Documentation: [swagger] [http://localhost:8080/](http://localhost:8080/)
- Posts [pagination included] [http://localhost:8080/posts](http://localhost:8080/posts)
- Todos [pagination included] [http://localhost:8080/todos](http://localhost:8080/posts)
- Posts with filter [http://localhost:8080/posts?filter_userId=33](http://localhost:8080/posts?filter_userId=33)
    - Other filters ``` filter_title, filter_body```
- Todos with filter [http://localhost:8080/todos?filter_userId=33](http://localhost:8080/todos?filter_userId=33)
    - Other filters ``` filter_title, filter_dueOn, filter_status```
    

Automation Testings
--------

CS - Code Sniffer automated coding standards checker

```bash
# Run CS checks:
$ docker-compose run api composer cs-check
# Fix CS errors:
$ docker-compose run api composer cs-fix
# Run PHPUnit tests:
$ docker-compose run api composer test
```
