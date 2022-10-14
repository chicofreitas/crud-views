<?php

namespace Chicofreitas\CrudViews\Commands;

use Illuminate\Console\Command;

class MakeViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:views {model}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create the CRUD views from Eloquent models.";

    /**
     * 
     */
    public function handle()
    {
        echo "Rendering Views";
    }
}
