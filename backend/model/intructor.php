<?php

require dirname(__DIR__).'\config\DB.php';
class intructor
{
    private $config;
    private $sql;

    public function __construct()
    {
        $this->config = new DB_config();
        $pdo = $this->config->get_pdo();
        $this->sql = new PDO($pdo[0], $pdo[1], $pdo[2]);
        $this->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function returnContent(string $unit)
    {
        $sql = $this->sql->prepare('SELECT data FROM content WHERE unit = :unit');
        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
        $sql->execute();
        $fetch = $sql->fetch(PDO::FETCH_ASSOC);
        echo $fetch['data'];
    }
    public function content(string $id_author, string $data, string $unit)
    {
        $return = '';
        $sql = $this->sql->prepare('SELECT id_author FROM content WHERE unit = :unit');
        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
        $sql->execute();
        $fetch = $sql->fetch(PDO::FETCH_ASSOC);
        if ($fetch != null) {
            try {
                $sql = $this->sql->prepare('UPDATE content SET data = :data WHERE unit = :unit;');
                $sql->bindParam(':data', $data, PDO::PARAM_STR);
                $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
                $sql->execute();
                $return = 'complete';
            } catch (PDOException $e) {
                echo $e->getMessage();
                $return = 'fail';
            }
        } elseif ($fetch == null) {
            try {
                $sql = $this->sql->prepare('INSERT INTO content(id_author,data,unit)
                                            VALUES (:id_author ,:data ,:unit );');
                $sql->bindParam(':id_author', $id_author, PDO::PARAM_INT, 10);
                $sql->bindParam(':data', $data, PDO::PARAM_STR);
                $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
                $sql->execute();
                $return = 'complete';
            } catch (PDOException $e) {
                echo $e->getMessage();
                $return = 'fail';
            }
        }

        return $return;
    }

    public function Make_examination(string $unit, string $exam_data, string $c1, string $c2, string $c3,
                                     string $c4, string $id_answer, string $score)
    {
        $return = '';
        try {
            $sql = $this->sql->prepare('INSERT INTO examination(id_exam,exam_data,c1,c2,c3,c4,score,id_answer,unit)
                                        VALUES (:id_exam ,:exam_data ,:c1 ,:c2 ,:c3 ,:c4 ,:score ,:id_answer ,:unit);');

            $sql->bindParam(':id_exam', uniqid('exam_'), PDO::PARAM_STR);
            $sql->bindParam(':exam_data', $exam_data, PDO::PARAM_STR);
            $sql->bindParam(':c1', $c1, PDO::PARAM_STR);
            $sql->bindParam(':c2', $c2, PDO::PARAM_STR);
            $sql->bindParam(':c3', $c3, PDO::PARAM_STR);
            $sql->bindParam(':c4', $c4, PDO::PARAM_STR);
            $sql->bindParam(':id_answer', $id_answer, PDO::PARAM_INT);
            $sql->bindParam(':score', $score, PDO::PARAM_INT);
            $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
            $sql->execute();
            $return = 'complete';
        } catch (PDOException $e) {
            echo $e->getMessage();
            $return = 'fail';
        }

        return $return;
    }

    public function Make_question(string $unit, string $exam_data, string $c1,
                                     string $c2, string $c3, string $c4, string $id_answer, string $score)
    {
        $return = '';
        try {
            $sql = $this->sql->prepare('INSERT INTO examination(id_exam,exam_data,c1,c2,c3,c4,score,id_answer,unit)
                                          VALUES (:id_exam ,:exam_data ,:c1 ,:c2 ,:c3 ,:c4 ,:score ,:id_answer,:unit);');

            $sql->bindParam(':id_exam', uniqid('question_'), PDO::PARAM_STR);
            $sql->bindParam(':exam_data', $exam_data, PDO::PARAM_STR);
            $sql->bindParam(':c1', $c1, PDO::PARAM_STR);
            $sql->bindParam(':c2', $c2, PDO::PARAM_STR);
            $sql->bindParam(':c3', $c3, PDO::PARAM_STR);
            $sql->bindParam(':c4', $c4, PDO::PARAM_STR);
            $sql->bindParam(':id_answer', $id_answer, PDO::PARAM_INT);
            $sql->bindParam(':score', $score, PDO::PARAM_INT);
            $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
            $sql->execute();
            $return = 'complete';
        } catch (PDOException $e) {
            echo $e->getMessage();
            $return = 'fail';
        }

        return $return;
    }
    public function listscore(string $unit)
    {
        $sql = $this->sql->prepare('SELECT name,type,score WHERE unit = :unit ;');
        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }
    public function unit_maker(string $unit, string $subunit, string $data)
    {
        $sql = $this->sql->prepare('INSERT INTO unit(unit,subunit,data) VALUES (:unit ,:subunit ,:data) ;');
        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
        $sql->bindParam(':data', $data, PDO::PARAM_STR);
        $sql->bindParam(':subunit', $subunit, PDO::PARAM_STR);
        $sql->execute();
    }
}
