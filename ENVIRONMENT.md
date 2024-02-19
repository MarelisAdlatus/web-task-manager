# <a id="top"></a> Environment for development and production

> Preparation of tools in the environment for the development and running of the application in production state.

The following is for the **Ubuntu 22.04** distribution, running in [WSL under Windows 11](WSL.md) on my machine.

It is about installing the required applications: [PHP](#php-xdebug), [Composer](#composer), [Node.js](#node-js) and [Git](#git).

And also installing optional applications: [MariaDB](#mariadb) and [NGINX](#nginx).

## <a id="php-xdebug"></a> PHP with Xdebug

> <ins>PHP</ins> is a general-purpose scripting language geared towards web development. <ins>Xdebug</ins> is a PHP extension which provides debugging and profiling capabilities. It uses the DBGp debugging protocol.

``` shell
# add repository
user@localhost:~$ sudo add-apt-repository ppa:ondrej/php

# install packages
user@localhost:~$ sudo apt install php8.2 php8.2-fpm php8.2-gd php8.2-common php8.2-imagick php8.2-imap php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-bz2 php8.2-intl php8.2-ldap php-phpseclib php-php-gettext php8.2-mysql php8.2-gmp php8.2-bcmath php8.2-sqlite3

# select alternative
user@localhost:~$ sudo update-alternatives --config php
There are 2 choices for the alternative php (providing /usr/bin/php).

  Selection    Path             Priority   Status
------------------------------------------------------------
* 0            /usr/bin/php8.2   82        auto mode
  1            /usr/bin/php8.1   81        manual mode

Press <enter> to keep the current choice[*], or type selection number:

# check php version
user@localhost:~$ php -v
PHP 8.2.15 (cli) (built: Jan 20 2024 14:17:05) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.2.15, Copyright (c) Zend Technologies
    with Zend OPcache v8.2.15, Copyright (c), by Zend Technologies

# edit files ...
user@localhost:~$ sudo nano /etc/php/8.2/cli/php.ini
user@localhost:~$ sudo nano /etc/php/8.2/fpm/php.ini

# ... with recommended values:
max_input_vars = 10000
memory_limit = 256M
max_execution_time = 300
post_max_size = 128M
upload_max_filesize = 128M
date.timezone = Europe/Prague

# restart php-fpm service
user@localhost:~$ sudo systemctl restart php8.2-fpm

# install memcached
user@localhost:~$ sudo apt install memcached php8.2-memcached libmemcached-tools

# install Xdebug
user@localhost:~$ sudo apt install php8.2-xdebug

# edit files ...
user@localhost:~$ sudo nano /etc/php/8.2/cli/php.ini
user@localhost:~$ sudo nano /etc/php/8.2/fpm/php.ini

# ... add to the end:
[Xdebug]
xdebug.mode = debug
xdebug.start_with_request = yes
xdebug.client_host = localhost
xdebug.client_port = 9000

# restart php-fpm service
user@localhost:~$ sudo systemctl restart php8.2-fpm

# check Xdebug
user@localhost:~$ php -m -c
...
[Zend Modules]
Xdebug
Zend OPcache
```

## <a id="composer"></a> Composer

> <ins>Composer</ins> is an application-level dependency manager for the PHP programming language that provides a standard format for managing dependencies of PHP software and required libraries.

``` shell
# install
user@localhost:~$ curl -sS https://getcomposer.org/installer | php
user@localhost:~$ sudo mv composer.phar /usr/local/bin/composer
user@localhost:~$ sudo chmod +x /usr/local/bin/composer

user@localhost:~$ composer --version
Composer version 2.7.1 2024-02-09 15:26:28

# check status
user@localhost:~$ composer diagnose

# update version
user@localhost:~$ composer self-update
```

## <a id="node-js"></a> Node.js with npm

> <ins>Node.js</ins> is a cross-platform, open-source JavaScript runtime environment that can run on Windows, Linux, Unix, macOS, and more. Node.js runs on the V8 JavaScript engine, and executes JavaScript code outside a web browser.

``` shell
# add repository
user@localhost:~$ sudo apt install ca-certificates curl gnupg
user@localhost:~$ curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | sudo gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
user@localhost:~$ NODE_MAJOR=20
user@localhost:~$ echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | sudo tee /etc/apt/sources.list.d/nodesource.list

user@localhost:~$ sudo apt update
user@localhost:~$ sudo apt install nodejs

# check version
user@localhost:~$ node -v
v20.11.1

user@localhost:~$ npm --version
10.2.4
```

## <a id="git"></a> Git

> <ins>Git</ins> is a distributed version control system that tracks changes in any set of computer files, usually used for coordinating work among programmers who are collaboratively developing source code during software development.

``` shell
user@localhost:~$ sudo apt install git

user@localhost:~$ git config --global user.name "User Name"
user@localhost:~$ git config --global user.email "user@hostname"
user@localhost:~$ git config --global init.defaultBranch main
user@localhost:~$ sudo git config --system core.editor nano
```

New SSH key to access GitHub repositories:

https://github.com/settings/keys

> button "New SSH key"
>
> - **Title:** user@localhost (WSL Ubuntu)
> - **Key type:** Authentication Key
> - **Key:** the contents of the SSH public key file

``` shell
# get public key for GitHub access
user@localhost:~$ cat .ssh/id_rsa.pub
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQDUeEzRT2YecGrbPTO3voq1wcUoF8T0uiJapGih0YGyJVvAS2jwtjs/Ua0lX5+B6Hi6YIplo5e61W5uOzjx/OFuS958A53IjBdbu6ttdG0q0SSuTdnp+UwutflkvTyBYNIwaMlmujr39sHBjJx6Zia0kcP48xS6tLaZthBcvP/AH2VIlfto08ndr3yPurVFtnia2ExT/WZetRw6UUPczhBuwMq6zZECu36jFFT9g2hzqEKgzKCBk1iev6e79qhj8MKYKOpYYQxv9w/XU449FHexhsYD8luySgQbd7MKA0ty1T07Z3Ix3u+rpNowCk5xaw8IYsM6B2e/8LOZajiOlr6yhtF5PRCys+4FoJlW4hIMp2k4O+HeQJritTPNFQGJNFOg2PsiIrl0P5wZJdAGeqMOvl5mfXQgq4JYR7Vw0yUMl7IqR1JowUaGOvWInHDRyAjTCCLki6EMfDkHmYtu2EhxY5aEQeIfwAeykfwETk5/uKYgKt2XKO44rTFFXX3Eb5TrvHSOslrOu936Bb+rWoRxwoLe6OKuUZ0dgWJKIpbd5st5y9hIWvFNzMtIlASAXJrj2W/jJvC/u7SP43VLkkY2g0keCBWNT9UOxFA50j01AQ7U2nuVAWMEpx/uZSpaPjPeSg/i732V642YQKYlbXeeD/xylc5aH4g6/RI/olY4Jw== user@localhost

# test connection
user@localhost:~$ ssh -T git@github.com
The authenticity of host 'github.com (140.82.121.3)' can't be established.
ED25519 key fingerprint is SHA256:+DiY3wvvV6TuJJhbpZisF/zLDA0zPMSvHdkr4UvCOqU.
This key is not known by any other names
Are you sure you want to continue connecting (yes/no/[fingerprint])? yes
Warning: Permanently added 'github.com' (ED25519) to the list of known hosts.
Hi MarelisAdlatus! You've successfully authenticated, but GitHub does not provide shell access.
```

## <a id="mariadb"></a> MariaDB

> <ins>MariaDB</ins> is a community-developed, commercially supported fork of the MySQL relational database management system (RDBMS), intended to remain free and open-source software under the GNU General Public License.

``` shell
# add repository
user@localhost:~$ curl -LsS https://downloads.mariadb.com/MariaDB/mariadb_repo_setup | sudo bash -s -- --mariadb-server-version=10.11

# install packages
user@localhost:~$ sudo apt install mariadb-server mariadb-client

# secure server
user@localhost:~$ sudo mysql_secure_installation
...
Enter current password for root (enter for none): <press ENTER>
...
Switch to unix_socket authentication [Y/n] n
 ... skipping.
Change the root password? [Y/n] n
 ... skipping.
Remove anonymous users? [Y/n] y
 ... Success!
Disallow root login remotely? [Y/n] y
 ... Success!
Remove test database and access to it? [Y/n] y
 - Dropping test database...
 ... Success!
 - Removing privileges on test database...
 ... Success!
Reload privilege tables now? [Y/n] y
 ... Success!

# generate a new password for the database admin
# apg is a great password generator, if you don't have it installed,
# run the command: sudo apt install apg
user@localhost:~$ apg -M NCL -s -a 1 -m 30 -n 1

Please enter some random data (only first 16 are significant)
(eg. your old password):>
3t2cL7e4YHjCLidoHn8uIgnv0XhlTn

user@localhost:~$ sudo mariadb

MariaDB [(none)]> GRANT ALL ON *.* TO 'admin'@'localhost' IDENTIFIED BY '3t2cL7e4YHjCLidoHn8uIgnv0XhlTn' WITH GRANT OPTION;
MariaDB [(none)]> FLUSH PRIVILEGES;
MariaDB [(none)]> QUIT;

user@localhost:~$ sudo mysqladmin version
mysqladmin  Ver 10.0 Distrib 10.11.7-MariaDB, for debian-linux-gnu on x86_64
Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Server version          10.11.7-MariaDB-1:10.11.7+maria~ubu2204
Protocol version        10
Connection              Localhost via UNIX socket
UNIX socket             /run/mysqld/mysqld.sock
...
```

## <a id="nginx"></a> NGINX with Let's Encrypt certbot
> <ins>NGINX</ins> is a web server that can also be used as a reverse proxy, load balancer, mail proxy and HTTP cache. <ins>Let's Encrypt</ins> is a non-profit certificate authority run by Internet Security Research Group (ISRG) that provides X.509 certificates for Transport Layer Security (TLS) encryption at no charge.

``` shell
# nginx
user@localhost:~$ sudo apt install nginx libnginx-mod-stream

# check version
user@localhost:~$ nginx -v
nginx version: nginx/1.18.0 (Ubuntu)

# create a temporary certificate
user@localhost:~$ sudo apt install ssl-cert
user@localhost:~$ sudo make-ssl-cert generate-default-snakeoil

# Let's Encrypt certbot
user@localhost:~$ sudo apt install certbot python3-certbot-nginx

# check status
user@localhost:~$ systemctl status certbot.timer
● certbot.timer - Run certbot twice daily
     Loaded: loaded (/lib/systemd/system/certbot.timer; enabled; vendor preset: enabled)
     Active: active (waiting) since Tue 2024-02-20 16:20:44 CET; 7s ago
    Trigger: Wed 2024-02-21 08:41:45 CET; 16h left
   Triggers: ● certbot.service

Feb 20 16:20:44 localhost systemd[1]: Started Run certbot twice daily.

user@localhost:~$ systemctl list-timers | grep -E "NEXT|certbot"
NEXT                        LEFT        LAST                        PASSED        UNIT                         ACTIVATES
Wed 2024-02-21 08:41:45 CET 16h left    n/a                         n/a           certbot.timer                certbot.service
```

:arrow_up: [Back to top](#top)