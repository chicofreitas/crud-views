<?php

namespace Chicofreitas\CrudViews;

use Chicofreitas\CrudViews\Commands\MakeViewCommand;
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
                MakeViewCommand::class,
            ]);
        }
    }    
}
