<?php

declare(strict_types=1);
require dirname(__DIR__).'\model\student.php';
require dirname(__DIR__).'\view\student.php';
class authen_controller
{
    private $student;
    private $view;
    public function __construct()
    {
        $this->student = new student();
        $this->view = new student_view();
    }
    public function listexam(string $unit)
    {
        $this->view->listexam($this->student->listexam($unit));
    }
}
