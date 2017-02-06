<?php

session_start();
include dirname(__DIR__).'\..\..\config\DB.php';
class authen
{
    private $config;
    public function __construct()
    {
        $this->config = new DB_config();
        $pdo = $this->config->get_pdo();
        $this->sql = new PDO($pdo[0], $pdo[1], $pdo[2]);
        $this->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function register(string $user, string $password, string $email, string $name)
    {
        try {
            if ($user != null && $password != null && $email != null) {
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $sql = $this->sql->prepare('SELECT * FROM user WHERE user = :user OR email= :email ;');
                $sql->bindParam(':user', $user);
                $sql->bindParam(':email', $email);
                $sql->execute();
                $fetch = $sql->fetch(PDO::FETCH_ASSOC);
                if ($fetch) {
                    return 'have_user';
                } else {
                    $sql = $this->sql->prepare('INSERT INTO user(user,name,password,email,score)
                                                VALUES (:user ,:name ,:password ,:email , 0 );');
                    $sql->bindParam(':user', $user, PDO::PARAM_STR);
                    $sql->bindParam(':password', $hash_pass, PDO::PARAM_STR);
                    $sql->bindParam(':email', $email, PDO::PARAM_STR);
                    $sql->bindParam(':name', $name, PDO::PARAM_STR);
                    $sql->execute();

                    return 'complete';
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'error : '.$e->getMessage();
        }
    }
    public function login(string $user, string  $password, string  $email)
    {
        try {
            $sql = $this->sql->prepare('SELECT id FROM user WHERE username= :username OR email= :email ;');
            $sql->bindParam(':username', $user, PDO::PARAM_STR, 64);
            $sql->bindParam(':email', $email, PDO::PARAM_STR, 64);
            $sql->execute();
            $fetch = $sql->fetch(PDO::FETCH_ASSOC);
            if ($fetch) {
                if (password_verify($password, $fetch['password'])) {
                    $_SESSION['id'] = $fetch['id'];

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'error : '.$e->getMessage();
        }
    }
    public function check_session(string $id_user)
    {
        if ($id_user != null) {
            $sql = $this->sql->prepare('SELECT id FROM user WHERE id = :id_user ; ');
            $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT, 11);
            $sql->execute();
            $fetch = $sql->fetch(PDO::FETCH_ASSOC);
            if ($fetch) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
?>
