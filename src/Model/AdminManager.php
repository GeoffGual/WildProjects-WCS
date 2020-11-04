<?php


namespace App\Model;


class AdminManager extends AbstractManager
{
    const TABLE = 'project';
    const LANGUAGE = 'language';
    const PICTURE = 'picture';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllProject()
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table");
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectLanguageNameById(int $id)
    {
        $statement = $this->pdo->prepare("SELECT language.name FROM $this->table JOIN "
            . self::LANGUAGE . " ON project.language_id=language.id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function selectMainPictureProject(int $id)
    {
        $statement = $this->pdo->query("SELECT picture.name, picture.is_main, picture.project_id 
            FROM $this->table JOIN " . self::PICTURE . " ON project.id=picture.project_id 
            WHERE is_main=1 AND project_id =$id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        return $statement->fetch();
    }
}
