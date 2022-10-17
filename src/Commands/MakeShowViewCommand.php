<?php

namespace Chicofreitas\CrudViews\Commands;

use Chicofreitas\CrudViews\Commands\MakeViewsCommand;

class MakeShowViewCommand extends MakeViewsCommand
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "crudview:show {model}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create the index view component from an Eloquent model.";

    /**
     * 
     * 
     * @var String
     */
    protected $method = "show";
    /**
     * 
     */
    public function handle()
    {
        $this->model = $this->argument('model');

        $this->fillables = $this->getModelFillables();

        $this->makeTemplate();
    }

    /**
     * 
     * 
     */
    protected function makeTemplate()
    {
        $this->info("Creating the {$this->method}.blade.php for {$this->model} model.");

        if (!$this->files->exists($path = $this->getPath($this->method))) {        
            $this->makeModelDirectory($path);
            $this->compileTemplate($path);
        }

        $this->info("View {$this->method}.blade.php created.");
    }

    public function compileTemplate($path)
    {
        $bar = $this->output->createProgressBar(count($this->fillables));

        $fp = fopen($path, "x+");
        
        $bar->start();

        foreach($this->fillables as $fillable):

            $line = <<<blade

<div class="">
    <p> {$fillable}: {{ \${$this->model}->{$fillable} }}</p>
</div>

blade;

            fwrite($fp, $line);

            $bar->advance();

        endforeach;

        fclose($fp);

        $bar->finish();

        $this->newLine(2);
    }

}
