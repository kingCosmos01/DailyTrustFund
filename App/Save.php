<?php


class Save
{
    private $user;
    public $data;

    public function __construct()
    {

        $this->user = $this->identifyUser();

        if ($this->user) {

            $this->data = 'open-modal';

            return $this->data;
        } else {
            $alias = "tried-save";
            header('location: ' . PUBLICROOT . 'login.php?alias=' . urlencode($alias));
            exit;
        }
    }


    private function identifyUser()
    {
        $current_user = '';

        if (isset($_SESSION['current_user_id'])) {
            $current_user = $_SESSION['current_user_id'];
        }

        return $current_user;
    }
}
