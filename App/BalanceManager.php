<?php



class BalanceManager extends Database
{
    private $balance;

    public function getAccountBalance($user)
    {
        $query = "SELECT SUM(trans_amount) AS total FROM transactions WHERE user_id = ? ";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute(array($user));
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
}
