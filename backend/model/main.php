<?php

require dirname(__DIR__).'\config\DB.php';

class main
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
    public function list_unit()
    {
        $sql = $this->sql->prepare('SELECT unit FROM unit GROUP BY unit ;');
        $sql->execute();
        $num = count($sql->fetchAll(PDO::FETCH_ASSOC));
        for ($i = 0; $i < $num; ++$i) {
            $sql = $this->sql->prepare('SELECT subunit FROM unit WHERE unit = :unit;');
            $sql->execute();
            $sql->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
