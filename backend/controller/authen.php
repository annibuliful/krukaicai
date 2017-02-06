<?php
declare(strict_types=1);
require dirname(__DIR__).'\model\authen.php';
require dirname(__DIR__).'\view\authen.php';
class authen_controller
{
    private $authen;
    private $view;
    public function __construct()
    {
        $this->authen = new authen();
        $this->view = new authen_view();
    }
    public function register(string $user, string $password, string $email,string $name)
    {
        $check = $this->authen->register($user, $password, $email,$name);
        print_r($check);
        if ($check == 'complete') {
            $this->view->register_complete();
        } elseif ($check == 'have_user') {
            $this->view->register_haveuser();
        } else {
            $this->view->error();
        }
    }
    public function login(string $user = null, string  $password, string  $email = null)
    {
        $check = $this->authen->login($user, $password, $email);
        if ($check == true) {
            header('location: main.php');
        } else {
            $this->view->login_fail();
        }
    }
}
?>
