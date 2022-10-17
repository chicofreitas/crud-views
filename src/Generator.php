<?php
namespace Chicofreitas\CrudViews;

class Generator
{
    /**
     * 
     * @var String
     */
    protected $view;

    public function compile()
    {
        echo $this->view;
    }
}
