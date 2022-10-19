<?php

namespace Chicofreitas\CrudViews\Commands;

use Chicofreitas\CrudViews\Commands\MakeViewsCommand;
use Illuminate\Support\Str;

class MakeIndexViewCommand extends MakeViewsCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "crudview:index {model}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create the index view component from an Eloquent model.";

    /**
     * 
     * @var String
     */
    protected $method = 'index';

    /**
     * 
     * @todo colocar o nome do modelo no plural
     */
    public function handle()
    {
        $this->model = $this->argument('model');

        $this->fillables = $this->getModelFillables();

        $this->makeTemplate();
    }

    /**
     * Generate the index view for a desired user.
     * 
     * @return string
     */
    protected function makeTemplate()
    {
        $this->line("Creating the {$this->method}.blade.php for {$this->model} model.");

        if ($this->files->exists($path = $this->getPath($this->method))) {        
            return $this->error("{$this->method} já existe!");
        }
        
        $this->makeModelDirectory($path);

        $this->files->put($path, $this->compileViewStub());

        $this->info("View {$this->method}.blade.php created.");
    }


    public function compileViewStub()
    {
        $stub = $this->files->get(__DIR__ . '/../stubs/index.stub');

        $this->replaceModelsName($stub)
            ->replaceModelName($stub)
            ->replaceTableHeadings($stub)
            ->replaceTableRows($stub)
            ->replaceUcModelsName($stub);

        return $stub;
    }

    /**
     * Replace the model name in the stub.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceModelName(&$stub)
    {
        $modelName = $this->argument('model');

        $stub = str_replace('{{model}}', $modelName, $stub);

        return $this;
    }

    /**
     * Replace the model name in the stub.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceUcModelsName(&$stub)
    {
        $ucModelsName = ucfirst(Str::pluralStudly($this->argument('model')));

        $stub = str_replace('{{ucModelsName}}', $ucModelsName, $stub);

        return $this;
    }

     /**
     * Replace the model name in the stub.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceModelsName(&$stub)
    {
        $modelsName = Str::pluralStudly(Str::camel($this->argument('model')));

        $stub = str_replace('{{models}}', $modelsName, $stub);

        return $this;
    }

    /**
     * 
     */
    public function replaceTableHeadings(&$stub)
    {   
        $tableHeadings = "";

        foreach($this->fillables as $fillable):

            $tableHeadings .= "<td>{$fillable}<td>\n";

        endforeach;

        $stub = str_replace('{{tableHeadings}}', $tableHeadings, $stub);

        return $this;
    }

    public function replaceTableRows(&$stub)
    {
        $tableRows = "";

        foreach($this->fillables as $fillable):
        
            $tableRows .= "<td>{{ \${$this->model}->{$fillable} }}</td>\n";
            
        endforeach;

        $stub = str_replace('{{tableRows}}', $tableRows, $stub);

        return $this;
    }

}
