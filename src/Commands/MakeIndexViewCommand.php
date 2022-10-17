<?php

namespace Chicofreitas\CrudViews\Commands;

use Chicofreitas\CrudViews\Commands\MakeViewsCommand;

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

    /**
     * 
     * @todo refatorar este elefante..
     * 
     * @var String $path
     */
    public function compileTemplate($path)
    {
        $bar = $this->output->createProgressBar(count($this->fillables));

        $fp = fopen($path, "x+");
        
        $bar->start();

        fwrite($fp, $this->openTable());
        fwrite($fp, $this->openHead());
        
        foreach($this->fillables as $fillable):

            $line = <<<blade
        
                <td>{$fillable}<td>

blade;
        
            fwrite($fp, $line);

        endforeach;

        fwrite($fp, $this->closeHead());
        fwrite($fp, $this->openBody());

        foreach($this->fillables as $fillable):
        
            $table_body = <<<blade

                <td>{{ \${$this->model}->{$fillable} }}</td>

blade;
            fwrite($fp, $table_body);
        endforeach;

        fwrite($fp, $this->closeBody());

        fwrite($fp, $this->closeTable());

        $bar->advance();

        fclose($fp);

        $bar->finish();

        $this->newLine(2);
    }

    /**
     * 
     * @return String
     */
    protected function openTable()
    {
        return <<<blade
<div class="">

    <table id="{$this->model}_table">

blade;
    }

    /**
     * 
     * @return String
     */
    protected function closeTable()
    {
        return <<<blade

    </table>

</div>

blade;
    }

    /**
     * 
     * @return String
     */
    public function openHead()
    {
        return <<<blade
        
        <thead>

            <th>
blade;
    }

    /**
     * 
     * @return String
     */
    public function closeHead()
    {
        return <<<blade

            </th>

        </thead>
blade;
    }

    /**
     * 
     * @return String
     */
    protected function openBody()
    {
        return <<<blade

        <tbody>

            @foreach( \${$this->model} as \${$this->model})
            <tr>

blade;
    }

    /**
     * 
     * @return String
     */
    protected function closeBody()
    {
        return <<<blade
            </tr>
            @endforeach

        </tbody>

blade;
    }

}
