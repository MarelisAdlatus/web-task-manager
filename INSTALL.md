# <a id="top"></a> Installing the web application

> Description of installation options for development and production.

## Content

[Installation for local development](#local-develop)\
[Installation for production with NGINX server](#production-nginx)

## What is required for development and production

Assuming you've already installed on your system:
- [PHP](https://www.php.net) (>= 8.2)
- [Composer](https://getcomposer.org) (>=2.7)
- [Node.js](https://nodejs.org) (>=20.11)
- [Git](https://git-scm.com) (>=2.34)

Optionally:
- [MariaDB](https://mariadb.org) (>=10.11)
- [NGINX](https://www.nginx.com) (>=1.18)

If you haven't, take a look at [Environment for development and production](ENVIRONMENT.md)

## <a id="local-develop"></a> Installation for local development

> Check out Composer, clone a repository from GitHub, set up your app, and launch your website and queue manager from the built-in tools.

``` shell
# check composer
user@localhost:~$ composer diagnose
user@localhost:~$ composer self-update

# create a parent folder for projects
user@localhost:~$ mkdir sites

# change the path to the projects folder
user@localhost:~/sites$ cd sites

# clone repository from GitHub
user@localhost:~$ git clone https://github.com/MarelisAdlatus/website-with-laravel.git
Cloning into 'website-with-laravel'...
...

# change the path to the project folder
user@localhost:~/sites$ cd website-with-laravel

# install dependencies
user@localhost:~/sites/website-with-laravel$ composer install
user@localhost:~/sites/website-with-laravel$ npm install

# create .env file and generate the application key
user@localhost:~/sites/website-with-laravel$ cp .env.example .env
user@localhost:~/sites/website-with-laravel$ php artisan key:generate

# build CSS and JS assets
user@localhost:~/sites/website-with-laravel$ npm run build
```

Start the embedded web server

``` shell
user@localhost:~/sites/website-with-laravel$ php artisan serve

   INFO  Server running on [http://127.0.0.1:8000].

  Press Ctrl+C to stop the server
```

Run the built-in queue manager in a new terminal window

``` shell
# unlike 'php artisan queue:work' tracks changes in the application.
# It continues to run until you press Ctrl+C
user@localhost:~/sites/website-with-laravel$ php artisan queue:listen

   INFO  Processing jobs from the [default] queue.
```

The Laravel project is now up and running. Access it at http://localhost:8000

## <a id="production-nginx"></a> Installation for production with NGINX server

> It consists of several steps:
> 1. [Preparing files for the web](#preparing-files-for-the-web)
> 2. [MariaDB database instead of default SQLite](#mariadb-database-instead-of-default-sqlite)
> 3. [Application settings](#application-settings)
> 4. [Site default settings for server with temporary ssl certificate](#site-default-settings-for-server-with-temporary-ssl-certificate)
> 5. [Let's Encrypt certification for https authentication](#lets-encrypt-certification-for-https-authentication)
> 6. [Permanent running of the jobs queue manager](#permanent-running-of-the-jobs-queue-manager)

### <a id="preparing-files-for-the-web"></a> 1. Preparing files for the web

``` shell
# check composer
root@pve:~# composer diagnose
root@pve:~# composer self-update

# create web folder
root@pve:~# mkdir -p /var/www/marelis-bamboo.cz
root@pve:~# cd /var/www/marelis-bamboo.cz

root@pve:/var/www/marelis-bamboo.cz# git clone https://github.com/MarelisAdlatus/website-with-laravel.git .

root@pve:/var/www/marelis-bamboo.cz# composer install --optimize-autoloader
root@pve:/var/www/marelis-bamboo.cz# npm install
root@pve:/var/www/marelis-bamboo.cz# npm run build
```
### <a id="mariadb-database-instead-of-default-sqlite"></a> 2. MariaDB database instead of default SQLite

``` shell
# generate a new password for the database db-name
# apg is a great password generator, if you don't have it installed,
# run the command: apt install apg
root@pve:~# apg -M NCL -s -a 1 -m 30 -n 1

Please enter some random data (only first 16 are significant)
(eg. your old password):>
db-password

root@pve:~# mariadb

MariaDB [(none)]> CREATE DATABASE db-name DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci;
MariaDB [(none)]> CREATE USER 'db-username'@'localhost' IDENTIFIED BY 'db-password';
MariaDB [(none)]> GRANT ALL PRIVILEGES ON db-name . * TO 'db-username'@'localhost';
MariaDB [(none)]> FLUSH PRIVILEGES;
MariaDB [(none)]> QUIT;
```

### <a id="application-settings"></a> 3. Application settings

``` shell
root@pve:/var/www/marelis-bamboo.cz# cp .env.example .env
root@pve:/var/www/marelis-bamboo.cz# nano .env
```
``` ini
APP_NAME=WebsiteWithLaravel
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=Europe/Prague
APP_URL=https://marelis-bamboo.cz

# default ...
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# optionally with the MariaDB database
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db-name
DB_USERNAME=db-username
DB_PASSWORD=db-password

# default ...
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# optionally with SMTP mail sending
MAIL_MAILER=smtp
MAIL_HOST=hostname
MAIL_PORT=587
MAIL_USERNAME=user@hostname
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="user@hostname"
MAIL_FROM_NAME="${APP_NAME}"
```
``` shell
root@pve:/var/www/marelis-bamboo.cz# php artisan key:generate

   INFO  Application key set successfully.

root@pve:/var/www/marelis-bamboo.cz# php artisan storage:link

   INFO  The [public/storage] link has been connected to [storage/app/public].

root@pve:/var/www/marelis-bamboo.cz# php artisan migrate:fresh --seed

                                     APPLICATION IN PRODUCTION.

 ┌ Are you sure you want to run this command? ──────────────────┐
 │ Yes                                                          │
 └──────────────────────────────────────────────────────────────┘

  Dropping all tables ............................................................... 67.42ms DONE

   INFO  Preparing database.

  Creating migration table ........................................................... 8.58ms DONE

   INFO  Running migrations.

  0001_01_01_000000_create_users_table .............................................. 54.85ms DONE
  0001_01_01_000001_create_cache_table .............................................. 14.23ms DONE
  0001_01_01_000002_create_jobs_table ............................................... 42.54ms DONE
  2024_02_16_221939_add_timezone_to_users_table ...................................... 9.24ms DONE
  2024_02_17_080736_add_language_to_users_table ...................................... 9.20ms DONE

   INFO  Seeding database.
```

File permissions for the web server

``` shell
# ownership
root@pve:~# chown -R www-data:www-data /var/www/marelis-bamboo.cz

# permissions
root@pve:~# chmod -R 755 /var/www/marelis-bamboo.cz
```

### <a id="site-default-settings-for-server-with-temporary-ssl-certificate"></a> 4. Site default settings for server with temporary ssl certificate

> Run before certification only for short time !!!

``` shell
root@pve:~# nano /etc/nginx/sites-available/marelis-bamboo.cz
```
``` nginx
server {
    listen 443 ssl http2;
    server_name marelis-bamboo.cz www.marelis-bamboo.cz;

    root /var/www/marelis-bamboo.cz/public;
    index index.php index.html;

    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    # Security headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload";
    add_header X-Frame-Options sameorigin;
    add_header X-Content-Type-Options nosniff;
    add_header Content-Security-Policy "frame-ancestors 'self';";
    add_header X-XSS-Protection "1; mode=block";
    add_header Referrer-Policy "same-origin";

    client_max_body_size 128M;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location /cgi-bin/ {
       gzip off;
       fastcgi_pass unix:/var/run/fcgiwrap.socket;
       fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
       include fastcgi_params;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_read_timeout 300;
     }

    location ~ /\.ht {
        deny all;
    }

    include snippets/snakeoil.conf;
}

server {
    listen 80;
    server_name marelis-bamboo.cz www.marelis-bamboo.cz;

    if ($host = www.marelis-bamboo.cz) {
        return 301 https://$host$request_uri;
    }

    if ($host = marelis-bamboo.cz) {
        return 301 https://$host$request_uri;
    }

    return 404;
}
```
``` shell
# enable website
root@pve:~# ln -s /etc/nginx/sites-available/marelis-bamboo.cz /etc/nginx/sites-enabled

# check config
root@pve:~# nginx -t

# reload server
root@pve:~# systemctl reload nginx
```
### <a id="lets-encrypt-certification-for-https-authentication"></a> 5. Let's Encrypt certification for https authentication

``` bash
root@pve:~# certbot --nginx --expand -d marelis-bamboo.cz,www.marelis-bamboo.cz
Saving debug log to /var/log/letsencrypt/letsencrypt.log
Enter email address (used for urgent renewal and security notices)
 (Enter 'c' to cancel): admin@marelis.cz

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
Please read the Terms of Service at
https://letsencrypt.org/documents/LE-SA-v1.3-September-21-2022.pdf. You must
agree in order to register with the ACME server. Do you agree?
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
(Y)es/(N)o: y

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
Would you be willing, once your first certificate is successfully issued, to
share your email address with the Electronic Frontier Foundation, a founding
partner of the Let's Encrypt project and the non-profit organization that
develops Certbot? We'd like to send you email about our work encrypting the web,
EFF news, campaigns, and ways to support digital freedom.
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
(Y)es/(N)o: n
Account registered.
...

# completing the site setup on the web server:

root@pve:~# nano /etc/nginx/sites-available/marelis-bamboo.cz

# replace ...

    include snippets/snakeoil.conf;

# ... with this:

    include /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

# check config
root@pve:~# nginx -t

# reload server
root@pve:~# systemctl reload nginx
```

### <a id="permanent-running-of-the-jobs-queue-manager"></a> 6. Permanent running of the jobs queue manager

> Stop before updating application files and then start again !!!

``` shell
root@pve:~# apt install supervisor

root@pve:~# nano /etc/supervisor/conf.d/website-with-laravel.conf
```
``` ini
[group:website-with-laravel-workers]
programs=default-worker,notification-worker

[program:default-worker]
command=nice -n 10 php artisan queue:work --queue=default,notification --verbose --timeout=120 --max-jobs=1000 --max-time=3600
directory=/var/www/marelis-bamboo.cz
numprocs=2
process_name=%(program_name)s_%(process_num)02d
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
redirect_stderr=true
stdout_logfile=/var/log/supervisor/website-with-laravel_default-worker.log

[program:notification-worker]
command=nice -n 10 php artisan queue:work --queue=notification,default --verbose --timeout=120 --max-jobs=1000 --max-time=3600
directory=/var/www/marelis-bamboo.cz
numprocs=2
process_name=%(program_name)s_%(process_num)02d
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
redirect_stderr=true
stdout_logfile=/var/log/supervisor/website-with-laravel_notification-worker.log
```
``` shell
root@pve:~# supervisorctl reread
website-with-laravel-workers: available

root@pve:~# supervisorctl update
website-with-laravel-workers: added process group

# this is how the queue manager is started:

root@pve:~# supervisorctl start website-with-laravel-workers:*

root@pve:~# supervisorctl status
website-with-laravel-workers:default-worker_00        RUNNING   pid 3806308, uptime 0:00:34
website-with-laravel-workers:default-worker_01        RUNNING   pid 3806309, uptime 0:00:34
website-with-laravel-workers:notification-worker_00   RUNNING   pid 3806310, uptime 0:00:34
website-with-laravel-workers:notification-worker_01   RUNNING   pid 3806311, uptime 0:00:34

# this stops the queue manager from running:

root@pve:~# supervisorctl stop website-with-laravel-workers:*
website-with-laravel-workers:default-worker_00: stopped
website-with-laravel-workers:default-worker_01: stopped
website-with-laravel-workers:notification-worker_00: stopped
website-with-laravel-workers:notification-worker_01: stopped
```

The Laravel project is now up and running. Access it at https://marelis-bamboo.cz

:arrow_up: [Back to top](#top)