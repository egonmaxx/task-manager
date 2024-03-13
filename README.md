# Task manager web application (VueJs & Laravel)

## How to install

- Make sure, you have docker and docker compose are install in your system
- Clone this repository
- Go into the directory where you cloned this repo. Run this command in terminal: docker-compose up -d or docker compose up -d 
- Wait until the docker containers start successfully.
- Login into the application container by this command: docker exec -ti --user=application laravel_backend_web bash
- Inside the container run this shell script: sh start.sh
- Type this url into your browser: http://127.0.0.1:15080
