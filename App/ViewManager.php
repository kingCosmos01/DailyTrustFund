<?php


class ViewManager
{

    public function __construct($view)
    {
        switch ($view) {
            case 'users':
                $this->renderView($view);
                break;
            case 'savings':
                $this->renderView($view);
                break;
            case 'transactions':
                $this->renderView($view);
                break;
            case 'withdrawal':
                $this->renderView($view);
                break;
        }
    }

    private function renderView($view)
    {
        if (file_exists(dirname(__DIR__) . '/public/components/' . $view . '.php')) {
            require dirname(__DIR__) . '/public/components/' . $view . '.php';
        } else {
            http_response_code(404);
            echo "<h1> View not Found </h1>";
            exit();
        }
    }
}
