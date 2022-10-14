<?php

namespace Chicofreitas\CrudViews\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use ReflectionClass;

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
     * @var Filesystem
     */
    protected $files;
    
    /**
     * 
     * @var String
     */
    protected $model;

    /**
     * 
     * @var String
     */
    protected $plural;

    /**
     * 
     * @var Array.
     */
    protected $fillables;
    
    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }
    /**
     * 
     */
    public function handle()
    {
        $this->fire();
    }

    /**
     * 
     */
    protected function fire()
    {
        $this->model = $this->argument('model');

        $this->fillables = $this->getModelFillables();

        $this->makeTemplates();
    }

    /**
     * 
     * 
     * @return Array $properties
     */
    protected function getModelFillables()
    {
        $reflector = new ReflectionClass('App\\Models\\'.ucfirst($this->model));

        $propertires = $reflector->getDefaultProperties();
        
        return $propertires['fillable'];
    }

    /**
     * 
     * 
     */
    protected function makeTemplates()
    {

        if (!$this->files->exists($path = $this->getPath('index'))) {        
            $this->makeModelDirectory($path);
        }

        $this->compileTemplates($path);
    }

    /**
     *
     * @params String $view 
     */
    protected function getPath($view)
    {
        return base_path().'/resources/views/components/'.$this->model.'/'.$view.'.blade.php';
    }

    /**
     * 
     * @params String $path
     */
    protected function makeModelDirectory($path)
    {
        $this->files->makeDirectory(dirname($path), 0777, true, true);
    }

    protected function compileTemplates($path)
    {
        $fp = fopen($path, "x+");
    
            
        foreach($this->fillables as $fillable):
            echo $fillable . "\n";
            $line = <<<blade

<div class="">
    <p> {$fillable}: {{ \${$this->model}->{$fillable} }}</p>
</div>

blade;

            fwrite($fp, $line);

        endforeach;
    }
}
