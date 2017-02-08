<?php

include dirname(__DIR__).'\config\DB.php';
class student
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
    public function listexam(string $unit)
    {
        $sql = $this->sql->prepare('SELECT id_exam,exam_data,c1,c2,c3,c4,score FROM examination
                                    WHERE unit = :unit ;');
        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
        $sql->execute();
        $fetch1 = array();
        while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($fetch1, $data);
        }
        $num = array();
        $fetch = array();
        while ($a < count($fetch1)) {
            $rand = (int) rand(0, count($fetch1) - 1);
            if (!in_array($rand, $num)) {
                echo $rand;
                array_push($num, $rand);
                array_push($fetch, $fetch1[$rand]);
                ++$a;
            } elseif (in_array($rand, $num)) {
                continue;
            }
        }

        return (array) $fetch;
    }
}
