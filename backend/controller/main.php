<?php

require dirname(__DIR__).'\model\authen.php';
require dirname(__DIR__).'\view\authen.php';
class main_controller
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new main();
        $this->view = new main_view();
    }

    public function list_unit()
    {
        $this->view->list_unit($this->model->list_unit());
    }
}
