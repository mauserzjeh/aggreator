# Aggreator local development setup

#### Requirements
- [Docker desktop](https://www.docker.com/products/docker-desktop)
- [GIT](https://git-scm.com/)
- [VSCode](https://code.visualstudio.com/) or any preferred IDE
- Access to this repository
- aggreator-local.zip (included in release)

#### Directory structure
```
.
└── aggreator/
    ├── .mysql/
    │   └── data/
    ├── .proxy/
    │   ├── conf.d/
    │   │   ├── aggreator.localhost.conf
    │   │   └── pma.aggreator.localhost.conf
    │   └── nginx.conf
    ├── application/
    ├── .env
    ├── docker-compose.yml
    └── readme.md (this file)
```
#### Installation
- Extract the contents of the aggreator-local.zip
- While staying in the root folder of the project clone the repository with the following command:
    ```shell
    $ git clone git@github.com:mauserzjeh/aggreator.git application
    ```
- Once the cloning is done, while still staying in the root folder of the project issue the following command:
    ```shell
    $ docker-compose up -d
    ```
- When the process is finished, we have to issue a few commands from the applications main container
    - Go into the main container
    ```shell
    $ docker exec -it ag_application /bin/bash
    ```
    - Install dependencies
    ```shell
    $ composer install
    ```
    - Run migrations
    ```
    $ php artisan migrate
    ```
    - When everything is finished, exit the container
    ```shell
    $ exit
    ```
- If everything done correctly the website can be reached on http://aggreator.localhost/
- PhpMyAdmin can be reached on http://pma.aggreator.localhost/
    - Credentials can be found in the .env file