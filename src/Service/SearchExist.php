<?php


namespace App\Service;


class SearchExist
{
    public function verify()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $word = $_POST['search'];
            preg_match("/([^A-Za-z0-9\s])/", $word, $result);
            if (empty($result)) {
                return $word;
            }
            header('Location: /');
        }
    }
}
