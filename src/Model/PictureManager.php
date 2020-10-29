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

    public function selectAllByIdPoject(int $idProject)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE project_id=:idProject");
        $statement->bindValue('idProject', $idProject, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
