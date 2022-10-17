<?php

namespace Chicofreitas\CrudViews;

use Chicofreitas\CrudViews\Commands\MakeIndexViewCommand;
use Chicofreitas\CrudViews\Commands\MakeCreateViewCommand;
use Chicofreitas\CrudViews\Commands\MakeEditViewCommand;
use Chicofreitas\CrudViews\Commands\MakeShowViewCommand;
use Illuminate\Support\ServiceProvider;

class CrudViewsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/crudviews.php' => config_path('crudviews.php'),
        ]);

        if($this->app->runningInConsole()){
            $this->commands([
                MakeIndexViewCommand::class,
                MakeCreateViewCommand::class,
                MakeEditViewCommand::class,
                MakeShowViewCommand::class,
            ]);
        }
    }    
}
