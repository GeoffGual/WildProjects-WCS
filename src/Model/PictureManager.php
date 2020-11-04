<?php


namespace App\Model;


class PictureManager extends AbstractManager
{
    const TABLE = 'picture';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectNamePictureById(int $id)
    {
        $statement = $this->pdo->prepare("SELECT name, is_main
        FROM $this->table
        WHERE project_id = :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
