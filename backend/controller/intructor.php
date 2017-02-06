<?php

require dirname(__DIR__).'\model\intructor.php';
require dirname(__DIR__).'\view\intructor.php';
class intructor_controller
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new intructor();
        $this->view = new intructor_view();
    }
    public function content(string $id_author, string $data, string $unit)
    {
        $check = $this->model->content($id_author, $data, $unit);
        if ($check == 'complete') {
            $this->view->contentComplete();
        } elseif ($check == 'fail') {
            $this->view->contentFail();
        }
    }
}
