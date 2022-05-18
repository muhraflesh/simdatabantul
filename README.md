# Base Larakuy
Base application skeleton laravel 5.4 Admin LTE 2.4.0 Bootstrap3

![larakuy-lte](https://user-images.githubusercontent.com/8111407/28573155-e1a1a824-7173-11e7-9370-f9b55616a52b.png)

## With Packages
* [Laravel-Gravatar](https://github.com/thomaswelton/laravel-gravatar) by [ThomasWelton](https://github.com/thomaswelton)
* [Laravel-Breadrumbs](https://github.com/davejamesmiller/laravel-breadcrumbs) by [DaveJamesMiller](https://github.com/davejamesmiller)
* [Laravel-Menu](https://github.com/lavary/laravel-menu) by [Lavary](https://github.com/lavary)

## Admin LTE 2.4.0

Admin LTE is a free to use Bootstrap admin template.
This template uses the default Bootstrap 3 styles along with a variety of powerful jQuery plugins and tools to create a powerful framework for creating admin panels or back-end dashboards.

Theme uses several libraries for charts, calendar, form validation, wizard style interface, off-canvas navigation menu, text forms, date range, upload area, form autocomplete, range slider, progress bars, notifications and much more.

### Theme Demo
[Template Demo](https://adminlte.io/preview) by [@almasaeed2010](https://github.com/almasaeed2010/AdminLTE)


## Laravel 5.4
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.
Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

### Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs/5.4).

# Installation

## Step 1

### With GIT
Clone git repository

With Git SSH
```
git clone git@github.com:larakuy/base.git larakuy-base
```

Or with HTTPS
```
git clone https://github.com/larakuy/base.git larakuy-base
```

Go to the project folder 
```
cd larakuy-base
```

Update composer 
```
composer update
```

## Step 2
Copy ```.env.example``` file to ```.env```

For Unix
```
cp .env.example .env
```
For Windows
```
copy .env.example .env
```

Run this commands

```
php artisan key:generate
```

Configure your ```.env``` file and run :
```
php artisan migrate
```

**WARNING** : For auth support, configure your ```.env``` file with ```database``` and ```smtp``` connection !

You are ready for a new Laravel 5.4 application with Admin LTE template !!
