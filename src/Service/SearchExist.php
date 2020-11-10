<?php


namespace App\Service;


class SearchExist
{
    public function verify()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $word = $_POST['search'];
            return $word;
        }
    }
}
