<?php
namespace Chicofreitas\CrudViews\Commands;

use Chicofreitas\CrudViews\Commands\MakeViewsCommand;

class MakeCreateViewCommand extends MakeViewsCommand
{   
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "crudview:create {model}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create the create view component from an Eloquent model.";

    /**
     * @var String
     */
    protected $method = 'create';
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

        fwrite($fp, $this->openForm());
        fwrite($fp, "@csrf\n");

        foreach($this->fillables as $fillable):

            $line = <<<blade

    <div class="">
        <label for="{$fillable}">\${$this->model}->{$fillable}</label>
        <input type="text" name="{$fillable}" />
    </div>

blade;
            fwrite($fp, $line);

            $bar->advance();

        endforeach;

        fwrite($fp, $this->closeForm());

        fclose($fp);

        $bar->finish();

        $this->newLine(2);
    }

    /**
     * 
     */
    protected function openForm()
    {
        return "<form method='POST' name='create_form' id='create_form'>\n";
    }

    /**
     * 
     */
    protected function closeForm()
    {
        return "</form>";
    }

}
