<?php

declare(strict_types=1);
require dirname(__DIR__).'\model\student.php';
require dirname(__DIR__).'\view\student.php';
class student_controller
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
    public function flagVideo(string $id_user, string $unit)
    {
        $this->student->flagVideo($id_user, $unit);
    }
}
