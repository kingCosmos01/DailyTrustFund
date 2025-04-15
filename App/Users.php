<?php


class Users extends Database
{

    public function getUsers()
    {
        $query = "SELECT * FROM users ORDER BY user_id DESC";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }


    public function getActiveUsers()
    {
        $query = "SELECT * FROM users WHERE status = 1";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getTotalUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();

        $data = $stmt->rowCount();
        return $data;
    }


   
}
