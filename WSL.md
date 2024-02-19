# <a id="top"></a> Linux running on Windows 11

> Description of installing WSL with Ubuntu 22.04.

## Content

[Installing WSL and the Ubuntu Linux distribution](#installing-wsl-and-the-ubuntu-linux-distribution)\
[Linux setup and SSH installation](#linux-setup-and-ssh-installation)\
[PHP and system time](#php-and-system-time)\
[MariaDB database](#mariadb-database)\
[NGINX web server with phpMyAdmin](#nginx-web-server-with-phpmyadmin)\
[Sending emails](#sending-emails)

## <a id="installing-wsl-and-the-ubuntu-linux-distribution"></a> Installing WSL and the Ubuntu Linux distribution

> Settings in Windows 11:
> - System / Optional Components / Additional Windows Features
> - Select "Windows Subsystem for Linux" + OK
> - Download and install the latest PowerShell version: https://github.com/PowerShell/PowerShell/releases
> - Run It

``` powershell
PowerShell 7.4.1

# update
PS C:\Users\marel> wsl --update

# restart WSL
PS C:\Users\marel> wsl --shutdown
```

``` powershell
PowerShell 7.4.1

# list of available linux distributions
PS C:\Users\marel> wsl --list --online

# installing a distribution by name
PS C:\Users\marel> wsl --install Ubuntu-22.04
```

> Restart Windows 11

> Pin the Application "Ubuntu 22.04.3 LTS" to the main panel and run it\
> or enter the **wsl** command in the PowerShell console

> New UNIX username: **marek** and password: **passssss**

``` powershell
Installing, this may take a few minutes...
Please create a default UNIX user account. The username does not need to match your Windows username.
For more information visit: https://aka.ms/wslusers
Enter new UNIX username: marek
New password:
Retype new password:
passwd: password updated successfully
Installation successful!
To run a command as administrator (user "root"), use "sudo <command>".
See "man sudo_root" for details.

Welcome to Ubuntu 22.04.3 LTS (GNU/Linux 5.15.133.1-microsoft-standard-WSL2 x86_64)

 * Documentation:  https://help.ubuntu.com
 * Management:     https://landscape.canonical.com
 * Support:        https://ubuntu.com/advantage

This message is shown once a day. To disable it please create the
/home/marek/.hushlogin file.
marek@NTB-MAREK:~$ exit
```

Set as default distribution in the PowerShell console

``` powershell
PowerShell 7.4.1

# available using the wsl command in the PowerShell console
PS C:\Users\marel> wsl -s Ubuntu-22.04

# create new config file:
PS C:\Users\marel> echo "" > .wslconfig
```

Edit the configuration file in the Windows 11 editor
> C:\\Users\\marel\\.wslconfig

``` ini
# Settings apply across all Linux distros running on WSL 2
[wsl2]

# The number of milliseconds that a VM is idle, before it is shut down.
# Only available for Windows 11.
vmIdleTimeout=300000

# Limits VM memory to use no more than 2 GB,
# this can be set as whole numbers using GB or MB
memory=2GB 

# Sets the VM to use two virtual processors
processors=2
```

## <a id="linux-setup-and-ssh-installation"></a> Linux setup and SSH installation

> First, launch the "Ubuntu 22.04.3 LTS" Application\
 or enter the **wsl** command in the PowerShell console.

``` shell
marek@NTB-MAREK:~$ sudo apt update
marek@NTB-MAREK:~$ sudo apt upgrade
marek@NTB-MAREK:~$ sudo apt install dbus-user-session
marek@NTB-MAREK:~$ sudo apt install ssh lfm apg nmap unzip net-tools

# turn off the daily report
marek@NTB-MAREK:~$ touch /home/marek/.hushlogin

# restart
marek@NTB-MAREK:~$ sudo reboot

# generate SSH key without password
marek@NTB-MAREK:~$ ssh-keygen -t rsa -b 4096
Generating public/private rsa key pair.
Enter file in which to save the key (/home/marek/.ssh/id_rsa):
Created directory '/home/marek/.ssh'.
Enter passphrase (empty for no passphrase):
Enter same passphrase again:
Your identification has been saved in /home/marek/.ssh/id_rsa
Your public key has been saved in /home/marek/.ssh/id_rsa.pub
The key fingerprint is:
SHA256:vGK164q9sJYdMfDL3oPxtHQf06u1hAXZimbPGOEhT1I marek@NTB-MAREK
...

marek@NTB-MAREK:~$ sudo su -

root@NTB-MAREK:~# nano /etc/wsl.conf
```
``` ini
[wsl]
autostop = false

[boot]
systemd = true

[automount]
root = /srv
options = "metadata,uid=0,gid=0,umask=022,fmask=000,case=off"

[user]
default = marek

[network]
generateHosts = false
```

If you are using [Bitvise SSH Client](https://www.bitvise.com/ssh-client-download) just add the following

``` shell
root@NTB-MAREK:~# nano /etc/ssh/sshd_config

# edit:

PermitRootLogin prohibit-password

root@NTB-MAREK:~# systemctl restart sshd

root@NTB-MAREK:~# mkdir .ssh
root@NTB-MAREK:~# nano /root/.ssh/authorized_keys

# insert your public key 'Bitvise SSH Client':

ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABgQDQWj5Go/Gky9foca6JGeXxWchOtVeZcmnB/zMaN5p9h4Z89Lh/etCuDUTNdM13UObSELE4vkuTA3H7mvsQ/i4YTdC2kapd6gbCxCLKOxaCqhN4B4v0LC194qpsCFIPhguEleAIiWT/H0qCDqlzTXBwsbhgFAFXXYVedbTY0yBkeIyIPFmg4zQR1qdCAMzUdvwYM4A0K4AmXeaYsmlIJ7FXCmZdwBcIoX2qL167asnBBBhgAL5KAvsMttSXBFXPW2RWKRZXux134YNkkN/P/3pZODlCBYBb0ZR6mwxrp7NavJJFW8VRqzK9M45pGR4IKI94vQ7z0fAqlOsGmad8laHJyalpJ3Wn4szNhZCZtTVd8+LS8D8Pnf9oBgdIGSHVL56T7GT+zd3X5nupcc4Ma5sQHUavcLVzCUDCZJ8KGNP9YqfHImFZJQ/8dPemCa1bRqA5pbUBoB5Q3nyIJMH0mxJsaqrchlN3NHPfTkncZhofwtP6wkTbmnjlspEXnyVzz80= marel@NTB-MAREK

root@NTB-MAREK:~# ifconfig
eth0: flags=4163<UP,BROADCAST,RUNNING,MULTICAST>  mtu 1500
        inet 172.20.173.115  netmask 255.255.240.0  broadcast 172.20.175.255
...
```

And now you can login **Bitvise SSH Client** as IPv4: 172.20.173.115 with method: publickey / Profile 1

## <a id="php-and-system-time"></a> PHP and system time

``` shell
# add repository
marek@NTB-MAREK:~$ sudo add-apt-repository ppa:ondrej/php

marek@NTB-MAREK:~$ sudo apt install php8.2 php8.2-fpm php8.2-gd php8.2-common php8.2-imagick php8.2-imap php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-bz2 php8.2-intl php8.2-ldap php-phpseclib php-php-gettext php8.2-mysql php8.2-gmp php8.2-bcmath php8.2-sqlite3

marek@NTB-MAREK:~$ sudo apt install php8.1 php8.1-fpm php8.1-gd php8.1-common php8.1-imagick php8.1-imap php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-bz2 php8.1-intl php8.1-ldap php-phpseclib php-php-gettext php8.1-mysql php8.1-gmp php8.1-bcmath php8.1-sqlite3

marek@NTB-MAREK:~$ sudo apt install php7.3 php7.3-fpm php7.3-gd php7.3-common php7.3-imagick php7.3-imap php7.3-xml php7.3-mbstring php7.3-curl php7.3-zip php7.3-bz2 php7.3-intl php7.3-ldap php-phpseclib php-php-gettext php7.3-mysql php7.3-gmp php7.3-bcmath php7.3-sqlite3

marek@NTB-MAREK:~$ sudo update-alternatives --config php
There are 3 choices for the alternative php (providing /usr/bin/php).

  Selection    Path             Priority   Status
------------------------------------------------------------
* 0            /usr/bin/php8.2   82        auto mode
  1            /usr/bin/php7.3   73        manual mode
  2            /usr/bin/php8.1   81        manual mode
  3            /usr/bin/php8.2   82        manual mode

Press <enter> to keep the current choice[*], or type selection number:

marek@NTB-MAREK:~$ php -v
PHP 8.2.15 (cli) (built: Jan 20 2024 14:17:05) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.2.15, Copyright (c) Zend Technologies
    with Zend OPcache v8.2.15, Copyright (c), by Zend Technologies

# edit files ...	
marek@NTB-MAREK:~$ sudo nano /etc/php/8.2/cli/php.ini
marek@NTB-MAREK:~$ sudo nano /etc/php/8.2/fpm/php.ini

#.. with recommended values:
max_input_vars = 10000
memory_limit = 256M
max_execution_time = 300
post_max_size = 128M
upload_max_filesize = 128M
date.timezone = Europe/Prague

marek@NTB-MAREK:~$ sudo systemctl restart php8.2-fpm

marek@NTB-MAREK:~$ sudo apt install memcached php8.2-memcached libmemcached-tools

marek@NTB-MAREK:~$ sudo memcstat --servers="127.0.0.1"
Server: 127.0.0.1 (11211)
...
		 
marek@NTB-MAREK:~$ timedatectl
               Local time: Mon 2024-02-05 13:38:44 CET
           Universal time: Mon 2024-02-05 12:38:44 UTC
                 RTC time: Mon 2024-02-05 12:38:44
                Time zone: Europe/Prague (CET, +0100)
System clock synchronized: yes
              NTP service: inactive
          RTC in local TZ: no
		  
# if the time zone was not correct:
marek@NTB-MAREK:~$ sudo timedatectl set-timezone Europe/Prague
```

## <a id="mariadb-database"> MariaDB database

``` shell
marek@NTB-MAREK:~$ curl -LsS https://downloads.mariadb.com/MariaDB/mariadb_repo_setup | sudo bash -s -- --mariadb-server-version=10.11

marek@NTB-MAREK:~$ sudo apt install mariadb-server mariadb-client

marek@NTB-MAREK:~$ sudo mysql_secure_installation
...
Enter current password for root (enter for none): ENTER
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
marek@NTB-MAREK:~$ apg -M NCL -s -a 1 -m 30 -n 1

Please enter some random data (only first 16 are significant)
(eg. your old password):>
0bEs3c8w1zqjZoHpVK9vHPumA3UMuI

marek@NTB-MAREK:~$ sudo mariadb

MariaDB [(none)]> GRANT ALL ON *.* TO 'admin'@'localhost' IDENTIFIED BY '0bEs3c8w1zqjZoHpVK9vHPumA3UMuI' WITH GRANT OPTION;
MariaDB [(none)]> FLUSH PRIVILEGES;
MariaDB [(none)]> QUIT;

marek@NTB-MAREK:~$ sudo mysqladmin version
mysqladmin  Ver 10.0 Distrib 10.11.7-MariaDB, for debian-linux-gnu on x86_64
Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Server version          10.11.7-MariaDB-1:10.11.7+maria~ubu2204
Protocol version        10
Connection              Localhost via UNIX socket
UNIX socket             /run/mysqld/mysqld.sock
Uptime:                 1 min 46 sec
...
```

## <a id="nginx-web-server-with-phpmyadmin"></a> NGINX web server with phpMyAdmin

``` shell
marek@NTB-MAREK:~$ sudo apt install nginx libnginx-mod-stream

marek@NTB-MAREK:~$ sudo systemctl stop nginx

# remove default files
marek@NTB-MAREK:~$ sudo rm -rf /var/www/html
marek@NTB-MAREK:~$ sudo rm /etc/nginx/sites-enabled/default
marek@NTB-MAREK:~$ sudo rm /etc/nginx/sites-available/default

# download and install the phpMyAdmin files
marek@NTB-MAREK:~$ wget https://www.phpmyadmin.net/downloads/phpMyAdmin-latest-all-languages.zip
marek@NTB-MAREK:~$ unzip phpMyAdmin-latest-all-languages.zip
marek@NTB-MAREK:~$ sudo mv phpMyAdmin-5.2.1-all-languages /var/www/pma.localhost

# https://www.phpmyadmin.net/themes
marek@NTB-MAREK:~$ wget https://files.phpmyadmin.net/themes/boodark-nord/1.1.0/boodark-nord-1.1.0.zip
marek@NTB-MAREK:~$ unzip boodark-nord-1.1.0.zip
marek@NTB-MAREK:~$ sudo mv boodark-nord /var/www/pma.localhost/themes/

# permissions
marek@NTB-MAREK:~$ sudo chown -R www-data:www-data /var/www/pma.localhost

# site settings for the server
marek@NTB-MAREK:~$ sudo nano /etc/nginx/sites-available/pma.localhost
```
``` nginx
server {
    listen 8080;
    server_name localhost;

    root /var/www/pma.localhost;
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
        try_files $uri $uri/ /index.php;
    }

    location ~ ^/(doc|sql|setup)/ {
        deny all;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        include snippets/fastcgi-php.conf;
     }

    location ~ /\.ht {
        deny all;
    }
	
}
```
``` shell
# enable site
marek@NTB-MAREK:~$ sudo ln -s /etc/nginx/sites-available/pma.localhost /etc/nginx/sites-enabled

# check config
marek@NTB-MAREK:~$ sudo nginx -t

# start the server
marek@NTB-MAREK:~$ sudo systemctl start nginx

marek@NTB-MAREK:~$ sudo nano /etc/nginx/sites-available/pma.localhost

# comment out the lines:

#location ~ ^/(doc|sql|setup)/ {
#    deny all;
#}

marek@NTB-MAREK:~$ sudo nginx -t
marek@NTB-MAREK:~$ sudo systemctl reload nginx
```

http://localhost:8080/setup

> Use the "new server" button
> 
> Basic settings:
> - **Long name of this server:** (nothing)
> - **Server name:** localhost
> - **Server Port:** (none)
> - **Server socket:** (none)
> - **Use SSL:** no
> - **Compress connection:** no
> 
> Login:
> - **Login type:** cookie
> 
> Login config:
> - **config login user:** admin
> - **Password for config login:** 0bEs3c8w1zqjZoHpVK9vHPumA3UMuI
> 
> Use the "Apply" button and then the "View" button.
> 
> Paste the lines with the settings into the clipboard.

``` shell
marek@NTB-MAREK:~$ sudo nano /var/www/pma.localhost/config.inc.php

# paste from clipboard SHIFT + INSERT

marek@NTB-MAREK:~$ sudo nano /etc/nginx/sites-available/pma.localhost

# uncomment the lines:

location ~ ^/(doc|sql|setup)/ {
    deny all;
}

marek@NTB-MAREK:~$ sudo nginx -t
marek@NTB-MAREK:~$ sudo systemctl reload nginx
```

https://localhost:8080

user: admin\
pass: 0bEs3c8w1zqjZoHpVK9vHPumA3UMuI

> Below is the message:\
> *The phpMyAdmin configuration storage is not completely configured, some extended features have been deactivated...*
> 
> Use the "Find out why" button and then the "Create" button.

## <a id="sending-emails"></a> Sending emails

``` shell
marek@NTB-MAREK:~$ sudo apt install ssmtp mailutils

marek@NTB-MAREK:~$ sudo nano /etc/ssmtp/revaliases

# edit:

root:admin@marelis.cz:vm-linux.marelis.cz:587
marek:admin@marelis.cz:vm-linux.marelis.cz:587

marek@NTB-MAREK:~$ sudo nano /etc/ssmtp/ssmtp.conf
```
``` ini
root=postmaster
mailhub=mail.marelis.cz:587
AuthUser=user@marelis.cz
AuthPass=password
UseTLS=YES
UseSTARTTLS=YES
rewriteDomain=marelis.cz
hostname=ntb-marek
FromLineOverride=YES
```
``` shell
marek@NTB-MAREK:~$ sudo chfn -f 'NTB-MAREK' root

marek@NTB-MAREK:~$ sudo grep root /etc/passwd
root:x:0:0:NTB-MAREK,,,:/root:/bin/bash

# if the firewall is active:
marek@NTB-MAREK:~$ sudo ufw allow 'Postfix Submission'

# test:
marek@NTB-MAREK:~$ echo "Hello, World!" | mailx -r software@marelis.cz -s 'Test Email' marelis.adlatus@gmail.com
```

:arrow_up: [Back to top](#top)