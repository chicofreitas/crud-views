<?php

namespace Chicofreitas\CrudViews\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use ReflectionClass;

class MakeViewsCommand extends Command
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
     * @var Array
     */
    protected $fillables;

    /**
     * 
     * @var Array
     */
    protected $views = ['index', 'create', 'show', 'edit'];
    
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
    
}
