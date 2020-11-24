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

    public function insert($picture, $id): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, is_main, project_id) 
        VALUES (:name, :is_main, :project_id)");
        $statement->bindValue(':name', $picture['name'], \PDO::PARAM_STR);
        $statement->bindValue(':is_main', $picture['is_main'], \PDO::PARAM_BOOL);
        $statement->bindValue(':project_id', $id, \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
