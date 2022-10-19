# Crud Views

Welcome to my Laravel Package

Add the crud-views repository in your __composer.json__

    "repositories": [
        {
            "type" : "vcs",
            "url" : "https://github.com/chicofreitas/crud-views"
        }
    ],

add the package into the require section

    "require": {
        ...
        "chicofreitas/crud-views" : "v0.0.1"
    },

and, in the psr-4 

    "autoload": {
        "psr-4": {
            ...
            "Chicofreitas\\" : "src/"
        }
    },


Add the following line to __composer.json__ file located in the root of Laravel application

    "autoload": {
        ...
        "Chicofreitas\\CrudViews\\": "vendor/chicofreitas/crud-views/src/"
    }

And in the __config/app.php__ add the service provider

    'providers' => {
        ...
        Chicofreitas\CrudViews\CrudViewsServiceProvider::class,
    }

In the console run

    $composer dump-autoload

You can verify if everything it's ok running

    $php artisan

and look for a _make:views_ command.