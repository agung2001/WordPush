<?php

namespace Wordpush\Controller;

/**
 * Collection of database migration methods
 * @package wordpush
 */

class View {

    /**
     * @access   protected
     * @var      string    $template    View template to use
     */
    protected $template;

    /**
     * @access   protected
     * @var      string    $view    View path to load
     */
    protected $view;

    /**
     * @access   protected
     * @var      array    $controller    Controller function to use within view
     */
    protected $controller;

    /**
     * View constructor
     * @return void
     */
    public function __construct($controller, $config){
        $this->controller = $controller;
        $this->template = $config['template'];
    }

    /**
     * Load view
     * @return void
     */
    public function load_view($path){
        include(SRC_PATH . '/View/' . str_replace('.', '/', $path) . '.php');
    }

    /**
     * Build view
     * @return void
     */
    public function build(){
        $controller = $this->controller;
        $db = $this->controller->getDb();
        require SRC_PATH . '/View/template/' . $this->template . '.php';
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param string $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

}