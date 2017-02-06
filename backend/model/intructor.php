<?php

require dirname(__DIR__).'\config\DB.php';
class content
{
  private $config;
  private $sql;

  function __construct()
  {
    $this->config = new DB_config();
    $pdo = $this->config->get_pdo();
    $this->sql = new PDO($pdo[0], $pdo[1], $pdo[2]);
    $this->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  public function content(string $id_author,string $data,string $unit)
  {
    $return = '';
    try {
      $sql = $this->sql->prepare('INSERT INTO content(id_author,data,unit)
                                  VALUES (:id_author ,:data ,:unit );');
      $sql->bindParam(':id_author',$id_author,PDO::PARAM_INT,10);
      $sql->bindParam(':data',$data,PDO::PARAM_STR);
      $sql->bindParam(':unit',$data,PDO::PARAM_STR);
      $sql->execute();
      $return = 'complete';

    } catch (PDOException $e) {
      echo $e->getMessage();
      $return = 'fail';

    }
    return $return;

  }
}
 ?>
