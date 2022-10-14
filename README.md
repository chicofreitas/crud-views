# Crud Views

Add the following line to composer.json file located in the root of Laravel application

    "autoload": {
        ...
        "Chicofreitas\\CrudViews\\": "vendor/chicofreitas/crud-views/src/"
    }

And in the __app.php__ add the service provider

    'providers' => {
        ...
        Chicofreitas\CrudViews\CrudViewsServiceProvider::class,
    }