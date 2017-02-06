<?php

include dirname(__DIR__).'\config\DB.php';
class CooP
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

    public function ranking()
    {
        $sql = $this->sql->prepare('SELECT name FROM user ORDER BY score DESC ;');
        $sql->execute();

        return (array) $sql->fetch(PDO::FETCH_ASSOC);
    }
}
