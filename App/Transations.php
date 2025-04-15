<?php

class Transactions extends Database
{

    public $error = [];

    public function getAllTransactions()
    {
        $query = "SELECT * FROM transactions ORDER BY trans_id DESC";
        // $user = $_SESSION['userID'];

        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $transactions;
    }

    public function getSingleTransaction($id)
    {

        $query = "SELECT * FROM transactions WHERE trans_id = ?";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute($id);
        $transaction = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $transaction;
    }

    public function selectAllSavingsTransactions()
    {
        $query = "SELECT * FROM transactions WHERE trans_type = ?";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute(array('savings'));
        $transaction = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $transaction;
    }

    public function selectAllWithdrawalTransactions()
    {
        $query = "SELECT * FROM transactions WHERE trans_type = ?";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute(array('withdrawal'));
        $transaction = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $transaction;
    }

    public function totalSavingsByUsers()
    {
        $query = "SELECT SUM(trans_amount) AS total FROM transactions WHERE trans_type = 'savings' ";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        $transaction = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $transaction;
    }

    public function totalWithdrawalsByUsers()
    {
        $query = "SELECT SUM(trans_amount) AS total FROM transactions WHERE trans_type = 'Withdrawal' ";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        $transaction = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $transaction;
    }

    public function makeDeposit($ref, $user, $amount, $type)
    {
        // getAmount
        // get transaction type
        // if savings, updates users savings balance
        // if deposit, instantiate another row with transaction details
        $query = "INSERT INTO transactions (trans_id, user_id, trans_amount, trans_type, status)
        VALUES (?, ?, ?, ?, ?)
        ";
        $stmt = $this->connect()->prepare($query);

        $newAmount = $this->taxUser($amount);
        $depositAmount = $newAmount['depositAmount'];

        if ($stmt->execute(array($ref, $user, $depositAmount, $type, 1))) {
            $this->sendPercent($newAmount['tax'], $user);
        }
    }

    private function taxUser($amount)
    {
        $tax = 0.02;

        $newAmount = ($tax * $amount);

        $amount = ($amount - $newAmount);

        $data = ['depositAmount' => $amount, 'tax' => $newAmount];

        return $data;
    }

    private function sendPercent($amount, $user)
    {
        $tax_id = uniqid();

        $query = "INSERT INTO taxes (tax_id, amount, user_id, status) VALUES(?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute(array($tax_id, $amount, $user, 1));
    }


    public function getTotalIncome()
    {
        $query = "SELECT SUM(amount) AS total FROM taxes";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        $income = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $income;
    }


    public function makeWithdrawal($amount, $user, $ref, $type, $password)
    {
        $result = null;

        if ($this->userExists($user, $password) == true) {

            $result = true;

            if ($this->hasPositiveBalance($user, $amount) == true) {
                $result = true;

                if ($this->withdraw($amount, $user, $ref, $type)) {
                    $result = true;
                } else {
                    $result = false;
                }
            }
        }

        return $result;
    }

    private function userExists($user, $password)
    {
        $query = "SELECT user_id AND password FROM users WHERE user_id = ? AND password = ?";
        $stmt = $this->connect()->prepare($query);

        $stmt->execute(array($user, $password));
        $count = $stmt->rowCount();

        if ($count === 1) {
            return true;
        } else {
            return false;
        }
    }


    private function hasPositiveBalance($user, $amount)
    {
        $balance = $this->totalSavingsByUsers();
        $balance = $balance[0]['total'];

        if ($user) {
            if ($amount <= $balance) {
                return true;
                // echo "Has Positive Balance!";
            } else {
                return false;
                // echo "Has Negative Balance!";
            }
        }
    }


    private function withdraw($amount, $user, $ref, $type)
    {
        $query = "SELECT SUM(trans_amount) AS total FROM transactions WHERE trans_type = 'savings' AND user_id = ? ";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute(array($user));

        $transaction = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $balance = $transaction[0]['total'];

        if ($balance >= $amount) {
            $query = "INSERT INTO transactions (trans_id, user_id, trans_amount, trans_type, status)
            VALUES (?, ?, ?, ?, ?)
            ";
            $stmt = $this->connect()->prepare($query);

            $newAmount = $this->taxUser($amount);
            $depositAmount = $newAmount['depositAmount'];

            if ($stmt->execute(array($ref, $user, -$amount, $type, 1))) {
                $this->sendPercent($newAmount['tax'], $user);
            }

            return true;
        } else {
            $this->error = ['msg' => 'Verify Balance!'];
            return false;
        }
    }
}
