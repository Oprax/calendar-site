# Project

[![Build Status](https://travis-ci.org/Oprax/calendar-site.svg?branch=master)](https://travis-ci.org/Oprax/calendar-site)

# Installation

This Project use [Laravel 5.1](https://laravel.com/docs/5.1/releases#laravel-5.1).

For PHP requirement please see [Laravel documentation](https://laravel.com/docs/5.1/#installation).

Install [PHP-FPM](http://php.net/manual/en/install.fpm.php) and [Nginx](http://nginx.org/) with configuration :
```
server {
        listen 80;
        listen [::]:80;

        # Root is `public` directory and not root project !
        root /path/to/project/public;

        index index.php index.html index.htm;

        server_name your.domain.com;


        location / {
                # First attempt to serve request as file, then
                # as directory, then fall back to displaying a 404.
                try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
                try_files $uri /index.php =404;
                fastcgi_pass unix:/var/run/php5-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
                include fastcgi_params;
                add_header X-Frame-Options SAMEORIGIN;
                proxy_hide_header X-Powered-By;
        }

        # deny access to .htaccess files, if Apache's document root
        # concurs with nginx's one
        #
        location ~ /\.ht {
                deny all;
        }
}

```

For Laravel configuration see `.env.example` and [Laravel documentation](https://laravel.com/docs/5.1/#configuration).

For data we use [MySQL](https://www.mysql.com/) and [Redis](http://redis.io/) for job queue, install them and put information on `.env`, for mailing we using [Mailgun](http://mailgun.com/).

Use [Envoy](https://laravel.com/docs/5.1/envoy) to push in production, here example of `Envoy.blade.php` :
First create user representing instance of your website, for exemple `calendar`, next create this in database like MySQL :
```sql
CREATE USER calendar@localhost IDENTIFIED BY 'password';
CREATE DATABASE calendar;
GRANT ALL PRIVILEGES ON calendar.* TO calendar@localhost;
```

In directory `share` we put all file contains data like `.env` and `vendor/` directory, this is not specific from a version.

You neet to have a repo with 
```
git remote add origin ssh://calendar@serverIP/home/calendar/repo
```

From [Grafikart](http://www.grafikart.fr/tutoriels/php/envoy-deploy-624)
```php
@setup
    $dir = "/home/calendar";
    $maxRelease = 3;

    $dirLinks = ['storage/app', 'storage/framework', 'storage/logs', 'storage/debugbar'];
    $fileLinks = ['.env'];

    $current = $dir."/current";
    $shared = $dir."/shared";
    $repo = $dir."/repo";
    $release = $dir."/releases/".date('YmdHis');
@endsetup

@macro('deploy')
    createrelease
    upgrade
    links
    current
    laravel
@endmacro

@task('prepare')
    mkdir -p {{ $repo }};
    mkdir -p {{ $shared }};
    cd {{ $repo }};
    git init --bare;
    echo "{{ $repo }}";
@endtask

@task('createrelease')
    mkdir -p {{ $release }};
    cd {{ $repo }};
    git archive master | tar -x -C {{ $release }};
    chmod 777 -Rf {{ $release }}/storage;
    echo "Directory {{ $release }} created";
@endtask

@task('upgrade')
    mkdir -p {{ $shared }}/vendor;
    ln -s {{ $shared }}/vendor {{ $release }}/vendor;
    cd {{ $release }};
    composer update --no-dev --no-progress;
    chmod 777 -Rf {{ $shared }}/vendor;
@endtask

@task('links')
    @foreach($dirLinks as $link)
        mkdir -p {{ $shared }}/{{ $link }};
        @if(strpos($link, '/'))
            mkdir -p {{ $release }}/{{ dirname($link) }};
        @endif
        ln -s {{ $shared }}/{{ $link }} {{ $release }}/{{ $link }};
        chmod 777 {{ $shared }}/{{ $link }};
    @endforeach
    @foreach($fileLinks as $link)
        ln -s {{ $shared }}/{{ $link }} {{ $release }}/{{ $link }};
    @endforeach
    echo "shared links created";
@endtask

@task('laravel')
    cd {{ $current }};
    php artisan migrate --force;
@endtask

@task('current')
    rm -f {{ $current }};
    ln -s {{ $release }} {{ $current }};
    chmod 777 -Rf {{ $current }};
    ls {{ $dir }}/releases | sort -r | tail -n +{{ $maxRelease + 1 }} | xargs -r -I{} rm -rf {{ $dir }}/releases/{};
    echo "{{ $current }} => {{ $release }}";
@endtask

@task('rollback')
    rm -f {{ $current }};
    ls {{ $dir }}/releases | tail -n 2 | head -n 1 | xargs -r -I{} ln -s {{ $dir }}/releases/{} {{ $current }};
@endtask
```
