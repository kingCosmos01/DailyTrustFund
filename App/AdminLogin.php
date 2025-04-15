<?php


class AdminLogin extends Database
{

    private $email;
    private $password;

    public $error = [];

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;

        if ($this->loginAdmin($this->email, $this->password) == true) {
            header("Location: dashboard.php");
        } else {
            $this->error = ['err' => 'Admin Not Found!'];
        }
    }

    private function adminExists($email, $password)
    {
        $query = "SELECT email AND password FROM dtf_admin WHERE email = ? AND password = ?";
        $stmt = $this->connect()->prepare($query);

        $stmt->execute(array($email, $password));
        $count = $stmt->rowCount();

        if ($count === 1) {
            return true;
        } else {
            return false;
        }
    }


    private function getAdmin($email,  $password)
    {
        $query = "SELECT * FROM dtf_admin WHERE email = ? AND password = ?";
        $stmt = $this->connect()->prepare($query);

        $stmt->execute(array($email, $password));
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    private  function loginAdmin($email, $password)
    {
        if ($this->adminExists($email, $password) == true) {

            $admin = $this->getAdmin($email, $password);

            session_start();

            $_SESSION['admin_id'] = $admin[0]['id'];
            $_SESSION['admin_fullname'] = $admin[0]['fullname'];
            $_SESSION['admin_email'] = $admin[0]['email'];

            return true;
        } else {
            return false;
        }
    }
}
