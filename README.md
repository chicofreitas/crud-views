# Crud Views

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