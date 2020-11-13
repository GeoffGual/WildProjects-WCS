<?php


namespace App\Service;


class LogAccess
{

    public function logPermission()
    {
        if (!isset($_SESSION['login'])) {
            header('location: /');
            exit();
        }
    }
}