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

    public function examination(string $unit, string $id_exam = null, string $exam_data, string $c1,
                                string $c2, string $c3, string $c4, string $score)
    {
        if ($id_exam == null) {
            $check = $this->model->Make_examination($unit, $exam_data, $c1, $c2, $c3, $c4, $score);
            if ($check == 'complete') {
                $this->view->examinationComplete();
            } elseif ($check == 'fail') {
                $this->view->examinationFail();
            }
        } elseif ($id_exam != null) {
            $check = $this->model->Update_examination($unit, $id_exam, $exam_data, $c1, $c2, $c3, $c4, $score);
            if ($check == 'complete') {
                $this->view->examinationComplete();
            } elseif ($check == 'fail') {
                $this->view->examinationFail();
            }
        }
    }
    public function question(string $unit, string $id_exam = null, string $exam_data, string $c1,
                                string $c2, string $c3, string $c4, string $score)
    {
        if ($id_exam == null) {
            $check = $this->model->Make_question($unit, $exam_data, $c1, $c2, $c3, $c4, $score);
            if ($check == 'complete') {
                $this->view->examinationComplete();
            } elseif ($check == 'fail') {
                $this->view->examinationFail();
            }
        } elseif ($id_exam != null) {
            $check = $this->model->Update_question($unit, $id_exam, $exam_data, $c1, $c2, $c3, $c4, $score);
            if ($check == 'complete') {
                $this->view->examinationComplete();
            } elseif ($check == 'fail') {
                $this->view->examinationFail();
            }
        }
    }
}
