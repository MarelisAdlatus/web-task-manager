# <a id="top"></a> Step-by-step application development notes

> Description and commands of the steps during the gradual development of the application.

## Content

[New Laravel project](#new-laravel-project)\
[Publish application on GitHub](#publish-application-on-github)\
[Support for VS Code editor](#support-for-vs-code-editor)\
[Directory for *.cgi scripts](#directory-for-cgi-scripts)\
[Environment settings](#environment-settings)\
[User login and registration](#user-login-and-registration)\
[User verification and password change by email](#verify-and-password-change-by-email)\
[Google font replacement](#google-font-replacement)\
[Bootstrap icons](#bootstrap-icons)\
[User's time zone at registration](#users-time-zone-at-registration)\
[User's language during registration and login](#users-language-registration-and-login)\
[Installing JQuery and SweetAlert2](#installing-jquery-and-sweetalert2)\
[Language switching and view translations](#language-switching-and-view-translations)

## <a id="new-laravel-project"></a> New Laravel project

``` shell
user@localhost:~$ git config --global --add safe.directory /home/marek/sites/website-with-laravel

user@localhost:~$ cd sites
user@localhost:~/sites$ composer create-project --prefer-dist laravel/laravel website-with-laravel dev-master

user@localhost:~/sites$ cd website-with-laravel

user@localhost:~/sites/website-with-laravel$ git init
user@localhost:~/sites/website-with-laravel$ git add .
user@localhost:~/sites/website-with-laravel$ git commit -m "New Laravel project"
```

## <a id="publish-application-on-github"></a> Publish application on GitHub

https://github.com/MarelisAdlatus?tab=repositories

> Button "New"
> - **Repository name:** website-with-laravel
> - **Description:** The basis for a website with the Laravel framework
> - **Type:** Public
> - **License:** Apache License 2.0

``` shell
user@localhost:~/sites/website-with-laravel$ git remote add origin git@github.com:MarelisAdlatus/website-with-laravel.git

user@localhost:~/sites/website-with-laravel$ git pull origin main --rebase
...
From github.com:MarelisAdlatus/website-with-laravel
 * branch            main       -> FETCH_HEAD
 * [new branch]      main       -> origin/main
Successfully rebased and updated refs/heads/main.

user@localhost:~/sites/website-with-laravel$ git push -u origin main
...
To github.com:MarelisAdlatus/website-with-laravel.git
   282760e..88900a9  main -> main
Branch 'main' set up to track remote branch 'main' from 'origin'.
```

## <a id="support-for-vs-code-editor"></a> Support for VS Code editor

> The combination of Windows 11 and WSL with Ubuntu Linux installed is a suitable combination for developing Laravel applications.

> This is how you can develop from [VSCode](https://code.visualstudio.com) directly in Windows 11, including debugging on the fly with Xdebug in running Linux!

> In the VS Code editor, the project folder can be opened from a running Linux in the WSL environment.

> And it's completely free for commercial use too, which is great, thanks to Microsoft for what they've been able to change and offer to communities :smiley:

``` shell
user@localhost:~/sites/website-with-laravel$ mkdir .vscode
user@localhost:~/sites/website-with-laravel$ nano .vscode/launch.json
```
``` json
{
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9000
        },
        {
            "name": "Launch Built-in web server",
            "type": "php",
            "request": "launch",
            "runtimeArgs": [
                "-dxdebug.mode=debug",
                "-dxdebug.start_with_request=yes",
                "-S",
                "localhost:3128"
            ],
            "program": "",
            "cwd": "${workspaceRoot}/public",
            "port": 9000,
            "serverReadyAction": {
                "pattern": "Development Server \\(http://localhost:([0-9]+)\\) started",
                "uriFormat": "http://localhost:%s",
                "action": "openExternally"
            }
        }
    ]
}
```
``` shell
user@localhost:~/sites/website-with-laravel$ nano .gitignore

# remove:
/.vscode

user@localhost:~/sites/website-with-laravel$ git add .

user@localhost:~/sites/website-with-laravel$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        modified:   .gitignore
        new file:   .vscode/launch.json

user@localhost:~/sites/website-with-laravel$ git commit -m "Support for VS Code editor"
user@localhost:~/sites/website-with-laravel$ git push
```

## <a id="directory-for-cgi-scripts"></a> Directory for *.cgi scripts

``` shell
user@localhost:~/sites/website-with-laravel$ mkdir -p public/cgi-bin

# git doesn't track empty directories, so an empty .gitkeep file is inserted (convention):
user@localhost:~/sites/website-with-laravel$ touch public/cgi-bin/.gitkeep
		
user@localhost:~/sites/website-with-laravel$ git commit -m "Directory for *.cgi scripts"
user@localhost:~/sites/website-with-laravel$ git push
```

## <a id="environment-settings"></a> Environment settings

``` shell
user@localhost:~/sites/website-with-laravel$ nano .env
```
``` ini
# edit:
APP_NAME=WebsiteWithLaravel
APP_TIMEZONE=Europe/Prague
APP_URL=http://localhost:8000

# default:
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# with the MariaDB database:
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db-name
DB_USERNAME=db-username
DB_PASSWORD=db-password

# default:
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# with SMTP mail sending:
MAIL_MAILER=smtp
MAIL_HOST=mail.domain
MAIL_PORT=587
MAIL_USERNAME=user@domain
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@domain"
MAIL_FROM_NAME="${APP_NAME}"
```
``` shell
user@localhost:~/sites/website-with-laravel$ php artisan config:clear

   INFO  Configuration cache cleared successfully.

user@localhost:~/sites/website-with-laravel$ php artisan storage:link

   INFO  The [public/storage] link has been connected to [storage/app/public].

user@localhost:~/sites/website-with-laravel$ php artisan migrate:fresh --seed

  Dropping all tables ................................................................................... 11.09ms DONE

   INFO  Preparing database.

  Creating migration table .............................................................................. 16.28ms DONE

   INFO  Running migrations.

  0001_01_01_000000_create_users_table ................................................................. 115.14ms DONE
  0001_01_01_000001_create_cache_table .................................................................. 22.17ms DONE
  0001_01_01_000002_create_jobs_table ................................................................... 81.53ms DONE

# test:

1. Open VSCode with project folder and run "Listen for Xdebug"

2. Start the web server:

user@localhost:~/sites/website-with-laravel$ php artisan serve

   INFO  Server running on [http://127.0.0.1:8000].
...

3. Open the website in the browser
```

## <a id="user-login-and-registration"></a> User login and registration

``` shell
user@localhost:~/sites/website-with-laravel$ composer require laravel/ui --dev
user@localhost:~/sites/website-with-laravel$ php artisan ui bootstrap --auth
...
  The [Controller.php] file already exists. Do you want to replace it? (yes/no) [no]
❯ yes
...

user@localhost:~/sites/website-with-laravel$ npm install
user@localhost:~/sites/website-with-laravel$ npm run build

user@localhost:~/sites/website-with-laravel$ git add .
user@localhost:~/sites/website-with-laravel$ git commit -m "User login and registration"
user@localhost:~/sites/website-with-laravel$ git push
```

## <a id="verify-and-password-change-by-email"></a> User verification and password change by email

``` shell
user@localhost:~/sites/website-with-laravel$ php artisan make:job SendEmailVerification
user@localhost:~/sites/website-with-laravel$ php artisan make:job SendEmailPasswordReset

# edit some files see git status below

user@localhost:~/sites/website-with-laravel$ git add .
user@localhost:~/sites/website-with-laravel$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        modified:   app/Http/Controllers/HomeController.php
        new file:   app/Jobs/SendEmailPasswordReset.php
        new file:   app/Jobs/SendEmailVerification.php
        modified:   app/Models/User.php
        modified:   routes/web.php

user@localhost:~/sites/website-with-laravel$ git commit -m "User verification and password change by email"
user@localhost:~/sites/website-with-laravel$ git push

# test:

1. Open VSCode with project folder and run "Listen for Xdebug"

2. Start the web server:

user@localhost:~/sites/website-with-laravel$ php artisan serve

   INFO  Server running on [http://127.0.0.1:8000].
...

3. Open the website in the browser

4. In a new terminal window, start the queue manager:

user@localhost:~/sites/website-with-laravel$ php artisan queue:listen

   INFO  Processing jobs from the [default] queue.

  2024-02-15 18:23:29 App\Jobs\SendEmailVerification ......................................................... RUNNING
  2024-02-15 18:23:30 App\Jobs\SendEmailVerification ................................................... 795.62ms DONE
  2024-02-15 18:24:27 App\Jobs\SendEmailPasswordReset ........................................................ RUNNING
  2024-02-15 18:24:27 App\Jobs\SendEmailPasswordReset .................................................. 282.94ms DONE

5. Register a new user on the website + confirm registration via email

6. Change the user's password on the website + confirm the password change from the email  
```

## <a id="google-font-replacement"></a> Google font replacement

> Google Fonts is a font service by USA-based company Google. The fonts on the service are all under a free software license. Which means they can be freely used. Currently it is only allowed to use the service in the European Union with the user's consent or with a legitimate interest.

Alternative:

> Self-host Open Source fonts in neatly bundled NPM packages:
>
> - https://fontsource.org/fonts/nunito
> - https://www.npmjs.com/package/@fontsource/nunito
> - https://github.com/fontsource/fontsource

``` shell
user@localhost:~/sites/website-with-laravel$ npm install @fontsource/nunito

# edit some files see git status below

user@localhost:~/sites/website-with-laravel$ npm run build

user@localhost:~/sites/website-with-laravel$ git add .
user@localhost:~/sites/website-with-laravel$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        modified:   package-lock.json
        modified:   package.json
        modified:   resources/sass/app.scss
        modified:   resources/views/layouts/app.blade.php
		
user@localhost:~/sites/website-with-laravel$ git commit -m "Google font replacement"
user@localhost:~/sites/website-with-laravel$ git push
```

## <a id="bootstrap-icons"></a> Bootstrap icons

``` shell
user@localhost:~/sites/website-with-laravel$v npm install bootstrap-icons --save-dev

# edit some files see git status below

user@localhost:~/sites/website-with-laravel$ npm run build

user@localhost:~/sites/website-with-laravel$ git add .
user@localhost:~/sites/website-with-laravel$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        modified:   package-lock.json
        modified:   package.json
        modified:   resources/sass/app.scss
		
user@localhost:~/sites/website-with-laravel$ git commit -m "Bootstrap icons"
user@localhost:~/sites/website-with-laravel$ git push
```

## <a id="users-time-zone-at-registration"></a> User's time zone at registration

``` shell
user@localhost:~/sites/website-with-laravel$ php artisan make:migration add_timezone_to_users_table

# edit some files see git status below

user@localhost:~/sites/website-with-laravel$ php artisan migrate

user@localhost:~/sites/website-with-laravel$ git add .
user@localhost:~/sites/website-with-laravel$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        modified:   app/Http/Controllers/Auth/RegisterController.php
        modified:   app/Models/User.php
        new file:   database/migrations/2024_02_16_221939_add_timezone_to_users_table.php
        modified:   resources/views/auth/register.blade.php
		
user@localhost:~/sites/website-with-laravel$ git commit -m "User's time zone at registration"
user@localhost:~/sites/website-with-laravel$ git push
```

## <a id="users-language-registration-and-login"></a> User's language during registration and login

``` shell
user@localhost:~/sites/website-with-laravel$ php artisan make:migration add_language_to_users_table
user@localhost:~/sites/website-with-laravel$ php artisan migrate

user@localhost:~/sites/website-with-laravel$ php artisan make:controller LangController
user@localhost:~/sites/website-with-laravel$ php artisan make:middleware LanguageManager

user@localhost:~/sites/website-with-laravel$ touch config/languages.php

# edit some files see git status below

user@localhost:~/sites/website-with-laravel$ git status
On branch main
Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        modified:   app/Http/Controllers/Auth/LoginController.php
        modified:   app/Http/Controllers/Auth/RegisterController.php
        new file:   app/Http/Controllers/LangController.php
        new file:   app/Http/Middleware/LanguageManager.php
        modified:   app/Models/User.php
        modified:   bootstrap/app.php
        new file:   config/languages.php
        new file:   database/migrations/2024_02_17_080736_add_language_to_users_table.php
        modified:   resources/views/auth/register.blade.php
        modified:   routes/web.php

user@localhost:~/sites/website-with-laravel$ git commit -m "User's language during registration and login"
user@localhost:~/sites/website-with-laravel$ git push

```
## <a id="installing-jquery-and-sweetalert2"></a> Installing JQuery and SweetAlert2

``` shell
user@localhost:~/sites/website-with-laravel$ mkdir public/js
user@localhost:~/sites/website-with-laravel$ wget -O public/js/jquery-3.7.1.min.js public/js https://code.jquery.com/jquery-3.7.1.min.js

user@localhost:~/sites/website-with-laravel$ npm install sweetalert2
...
1 low severity vulnerability
...

user@localhost:~/sites/website-with-laravel$ npm audit
...
sweetalert2  >=11.6.14
sweetalert2 v11.6.14 and above contains potentially undesirable behavior - https://github.com/advisories/GHSA-mrr8-v49w-3333
fix available via `npm audit fix --force`
Will install sweetalert2@11.6.13, which is a breaking change
node_modules/sweetalert2
...

# edit some files see git status below

user@localhost:~/sites/website-with-laravel$ npm run build

user@localhost:~/sites/website-with-laravel$ git add .
user@localhost:~/sites/website-with-laravel$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        modified:   package-lock.json
        modified:   package.json
        new file:   public/js/jquery-3.7.1.min.js
        modified:   resources/js/app.js
        modified:   resources/views/home.blade.php
        modified:   resources/views/layouts/app.blade.php
		
user@localhost:~/sites/website-with-laravel$ git commit -m "Installing JQuery and SweetAlert2"
user@localhost:~/sites/website-with-laravel$ git push
```

## <a id="language-switching-and-view-translations"></a> Language switching and view translations

> the welcome page will be edited later

``` shell
user@localhost:~/sites/website-with-laravel$ php artisan lang:publish
user@localhost:~/sites/website-with-laravel$ cp -r lang/en lang/cs
user@localhost:~/sites/website-with-laravel$ touch lang/{en,cs}/app.php

user@localhost:~/sites/website-with-laravel$ php artisan make:view navbar-dropdown-lang

# edit some files see git status below

user@localhost:~/sites/website-with-laravel$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        new file:   lang/cs/app.php
        new file:   lang/cs/auth.php
        new file:   lang/cs/pagination.php
        new file:   lang/cs/passwords.php
        new file:   lang/cs/validation.php
        new file:   lang/en/app.php
        new file:   lang/en/auth.php
        new file:   lang/en/pagination.php
        new file:   lang/en/passwords.php
        new file:   lang/en/validation.php
        modified:   resources/views/auth/login.blade.php
        modified:   resources/views/auth/passwords/confirm.blade.php
        modified:   resources/views/auth/passwords/email.blade.php
        modified:   resources/views/auth/passwords/reset.blade.php
        modified:   resources/views/auth/register.blade.php
        modified:   resources/views/auth/verify.blade.php
        modified:   resources/views/home.blade.php
        modified:   resources/views/layouts/app.blade.php
        new file:   resources/views/navbar-dropdown-lang.blade.php
        modified:   resources/views/welcome.blade.php
		
user@localhost:~/sites/website-with-laravel$ git commit -m "Language switching and view translations"
user@localhost:~/sites/website-with-laravel$ git push
``` 

## :white_check_mark: Release v0.1

> Basic site with users and multiple languages

https://github.com/MarelisAdlatus/website-with-laravel/releases/tag/v0.1

:arrow_up: [Back to top](#top)