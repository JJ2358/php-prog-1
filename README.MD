# LAMP with Tailwind boilerplate

## local setup

run the below command to build the image, create and start the containers

```
docker-compose up --build
```

if image is already built use the following to start the containers in detached mode

```
docker-compose up -d
```

## Docker services

### web-server

A php image built using the Docker official image from [DockerHub](https://hub.docker.com/_/php). Defined in the php.Dockerfile. Can be accessed from http://localhost

### mysql-server

a mysql image built from DockerHub.

- username = root

### phpmyadmin

a phpmyadmin image built from DockerHub. Can be accessed from http://localhost:5000

### .env

your mysql root password must be set using a .env file.

```
MYSQL_ROOT_PASSWORD = "your root password"
```

## Local development

### Using docker exec
You can run commands from the web-server container using the `docker exec` command.

```bash
docker exec -it ws bash
```
the above command will open a bash shell in the `ws` container. `ws` is the name of the web-server container which can be found in the `docker-compose.yml` file.

### Composer
To run `composer install` from the web-server container use the following command

```bash
docker exec -it ws composer install
```
the above command executes the `composer install` command from the `ws` container. 

### bundle and build css
Required node modules can be installed using `npm install`. Can use the following docker exec command to install the modules.

```bash
docker exec -it ws npm install
```

to watch and build css run `npm run watch`. Can use the following docker exec command to run the command in the `ws` container.
    
```bash
docker exec -it ws npm run watch
```

### ini
- `ini/upload.ini` can be used to control php upload settings
- `ini/xdebug.ini` can be used to control xdebug settings

### apache
The `apache/000-default.conf` file can be used to modify the default vhost settings for the apache server.