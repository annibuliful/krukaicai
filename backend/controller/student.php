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
    public function check_examination(string $id_user, string $unit)
    {
        $check = $this->student->check_examination($id_user, $unit);
        if ($check == true) {
            echo 'สอบไปแล้ว';
        } elseif ($check == false) {
            echo 'ยังไม่ได้สอบ';
        }
    }
    public function answer_exam(string $id_user, array $id_exam, array $id_answer, string $unit, string $type)
    {
        $check = $this->student->answer_exam($id_user, $id_exam, $id_answer, $unit, $type);
        if ($check != null) {
            $this->student->show_score($check);
        } else {
            echo 'error';
        }
    }
    public function listscore()
    {
        $check = $this->student->listscore();
        if ($check != null && gettype($check) == 'array') {
            $this->student->listscore();
        } else {
            echo 'error';
        }
    }
}
