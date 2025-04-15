<?php


class Login extends Database
{

    private $email;
    private $password;

    public $error = [];

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;

        if ($this->loginUser($this->email, $this->password) == true) {
            header("Location: dashboard.php");
        } else {
            $this->error = ['err' => 'User Not Found!'];
        }
    }

    private function userExists($email, $password)
    {
        $query = "SELECT email AND password FROM users WHERE email = ? AND password = ?";
        $stmt = $this->connect()->prepare($query);

        $stmt->execute(array($email, $password));
        $count = $stmt->rowCount();

        if ($count === 1) {
            return true;
        } else {
            return false;
        }
    }


    private function getUser($email,  $password)
    {
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $this->connect()->prepare($query);

        $stmt->execute(array($email, $password));
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    private  function loginUser($email, $password)
    {
        if ($this->userExists($email, $password) == true) {

            $user = $this->getUser($email, $password);

            session_start();

            $_SESSION['userID'] = $user[0]['user_id'];
            $_SESSION['user_fullname'] = $user[0]['first_name'] . ' ' . $user[0]['last_name'];
            $_SESSION['first_name'] = $user[0]['first_name'];
            $_SESSION['last_name'] = $user[0]['last_name'];
            $_SESSION['user_email'] = $user[0]['email'];

            return true;
        } else {
            return false;
        }
    }
}
