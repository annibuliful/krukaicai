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
                array_push($num, $rand);
                array_push($fetch, $fetch1[$rand]);
                ++$a;
            } elseif (in_array($rand, $num)) {
                continue;
            }
        }

        return (array) $fetch;
    }
    public function flagVideo(string $id_user, string $unit)
    {
        $sql = $this->sql->prepare('INSERT INTO flagVideo(id_user,unit,last) VALUES (:id_user ,:unit,1);');
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_STR);
        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
        $sql->execute();
    }
    public function check_examination(string $id_user, string $unit)
    {
        $sql = $this->sql->prepare('SELECT id FROM check_examination WHERE id_user = :id_user
                                  AND unit = :unit ;');
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_STR);
        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
        $sql->execute();
        $fetch = $sql->fetch(PDO::FETCH_ASSOC);
        if ($fetch) {
            return true;
        } else {
            return false;
        }
    }
    public function answer_exam(string $id_user, array $id_exam, array $id_answer, string $unit, string $type)
    {
        $sumScore = 0;
        if (count($id_exam) == count($id_answer)) {
            $sql = $this->sql->prepare('SELECT score FROM user WHERE id = :id_user');
            $sql->bindparam(':id_user', $id_user, PDO::PARAM_INT);
            $sql->execute();
            $score = $sql->fetch(PDO::FETCH_ASSOC);
            if ($score) {
                $sql = $this->sql->prepare('SELECT unit FROM check_examination WHERE id_user = :id_user
                                            AND unit = :unit ;');
                $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
                $sql->execute();
                $fetch = $sql->fetch(PDO::FETCH_ASSOC);
                if (!$fetch) {
                    $num = count($id_exam);
                    for ($i = 0; $i < $num; ++$i) {
                        $sql = $this->sql->prepare('SELECT score FROM examination WHERE id_exam = :id_exam
                                                    AND id_answer = :id_answer AND unit= :unit');
                        $sql->bindParam(':id_exam', $id_exam[$i], PDO::PARAM_STR);
                        $sql->bindParam(':id_answer', $id_answer[$i], PDO::PARAM_INT);
                        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
                        $sql->execute();
                        $fetch = $sql->fetch(PDO::FETCH_ASSOC);
                        if ($fetch) {
                            $sql = $this->sql->prepare('UPDATE user SET score = score + :score
                                                        WHERE id = :id_user');
                            $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                            $sql->bindParam(':score', $fetch['score'], PDO::PARAM_INT);
                            $sql->execute();
                            $sumScore += $fetch['score'];
                        } elseif (!$fetch) {
                            continue;
                        }
                    }
                    $sql = $this->sql->prepare('INSERT INTO check_examination(id_user,unit,type,score)
                                                VALUES (:id_user ,:unit ,:type ,:score)');
                    $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
                    $sql->bindParam(':type', $type, PDO::PARAM_STR); // before และ after
                    $sql->bindParam(':score', $sumScore, PDO::PARAM_INT);
                    $sql->execute();

                    return $sumScore;
                } elseif ($fetch) {
                    echo 'string';
                    $num = count($id_exam);
                    for ($i = 0; $i < $num; ++$i) {
                        $sql = $this->sql->prepare('SELECT score FROM examination WHERE id_exam = :id_exam
                                                  AND id_answer = :id_answer AND unit= :unit');
                        $sql->bindParam(':id_exam', $id_exam[$i], PDO::PARAM_STR);
                        $sql->bindParam(':id_answer', $id_answer[$i], PDO::PARAM_INT);
                        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
                        $sql->execute();
                        $fetch = $sql->fetch(PDO::FETCH_ASSOC);
                        if ($fetch) {
                            $sumScore += $fetch['score'];
                        } elseif (!$fetch) {
                            continue;
                        }
                    }
                    $sql = $this->sql->prepare('INSERT INTO check_examination(id_user,unit,type,score)
                                              VALUES (:id_user ,:unit ,:type ,:score)');
                    $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
                    $sql->bindParam(':type', $type, PDO::PARAM_STR); // before และ after
                    $sql->bindParam(':score', $sumScore, PDO::PARAM_INT);
                    $sql->execute();

                    return $sumScore;
                }
            }
        } elseif (count($id_exam) != count($id_answer)) {
            return false;
        }
    }
    public function listscore(string $id_user, string $unit)
    {
        $sql = $this->sql->prepare('SELECT score FROM check_examination WHERE id_user = :id_user AND unit = :unit ;');
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->bindParam(':unit', $unit, PDO::PARAM_STR);
        $sql->execute();

        return (array) $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
