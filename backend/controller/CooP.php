<?php

require dirname(__DIR__).'\model\CooP.php';
require dirname(__DIR__).'\view\CooP.php';
class CooP_controller
{
    private $CooP;
    private $view;
    public function __construct()
    {
        $this->CooP = new CooP();
        $this->view = new CooP_view();
    }

    public function ranking()
    {
        $this->view->ranking($this->CooP->ranking());
    }
}
