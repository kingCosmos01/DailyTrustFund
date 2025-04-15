<?php


class   Register extends Database
{

    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $confirm_password;

    public $error;

    public function __construct($data)
    {
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->confirm_password = $data['confirm_password'];

        if ($this->nonEmpty() == true) {
            $this->saveCredentials();
        } else {
        }
    }


    private function nonEmpty()
    {
        $result = null;

        if (
            !empty($this->first_name) && !empty($this->last_name) && !empty($this->email)
            && !empty($this->password) && !empty($this->confirm_password)
        ) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    private function passwordLength()
    {
        if (strlen($this->password) < 5) {
            $this->error = ['type' => 'err', 'msg' => 'Password must be 5 characters and above!'];
            return false;
        } else {
            return true;
        }
    }

    private function passwordVerify()
    {
        $result = null;

        if ($this->passwordLength() == true) {
            if ($this->password != $this->confirm_password) {
                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }

    private function saveCredentials()
    {
        if ($this->passwordVerify() == true) {
            $this->saveData(
                $this->first_name,
                $this->last_name,
                $this->email,
                $this->password
            );
        } else {
            $this->error = ['type' => 'err', 'msg' => 'The two passwords do not match!'];
        }
    }

    private function saveData($first_name, $last_name, $email, $password)
    {
        $userID = uniqid();
        $date = date("d-m-Y");

        $query = "INSERT INTO users (user_id, first_name, last_name, email, password, date, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute(array($userID, $first_name, $last_name, $email, $password, $date, 0));

        $_SESSION['userID'] = $userID;
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;

        return true;
    }
}
