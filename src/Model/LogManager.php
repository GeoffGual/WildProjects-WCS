<?php


namespace App\Model;


class LogManager extends AbstractManager
{
    const TABLE = 'admin';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function checkmdp($login)
    {
        $statement = $this->pdo->prepare("SELECT password FROM " . self::TABLE . " WHERE `login` = :login");
        $statement->bindValue(':login', $login, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

}