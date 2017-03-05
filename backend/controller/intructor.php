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
    public function returnContent(string $unit)
    {
        $this->model->returnContent($unit);
    }
    public function content(string $id_author, string $data, string $unit)
    {
        $this->model->content($id_author, $data, $unit);
    }

    public function examination(string $unit, string $exam_data, string $c1,
                                string $c2, string $c3, string $c4, string $id_answer, string $score)
    {
        $check = $this->model->Make_examination($unit, $exam_data, $c1, $c2, $c3, $c4, $id_answer, $score);
        if ($check == 'complete') {
            $this->view->examinationComplete();
        } elseif ($check == 'fail') {
            $this->view->examinationFail();
        }
    }
    public function question(string $unit, string $exam_data, string $c1,
                             string $c2, string $c3, string $c4, string $id_answer, string $score)
    {
        $check = $this->model->Make_question($unit, $exam_data, $c1, $c2, $c3, $c4, $id_answer, $score);
        if ($check == 'complete') {
            $this->view->examinationComplete();
        } elseif ($check == 'fail') {
            $this->view->examinationFail();
        }
    }
    public function listscore(string $unit)
    {
        $check = $this->model->listscore($unit);
        if ($check != null) {
            $this->view->listscore($check);
        }
    }
    public function unit_maker(string $unit, string $subunit, string $data)
    {
        $this->model->unit_maker($unit, $subunit, $data);
    }
}
