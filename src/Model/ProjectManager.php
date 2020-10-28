<?php


namespace App\Model;


class ProjectManager extends AbstractManager
{
    const TABLE = 'project';
    const TABLEPICTURE = 'picture';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectMainPictureProject1()
    {
        $statement = $this->pdo->query("SELECT * FROM $this->table JOIN " . self::TABLEPICTURE .
            " ON project.id=picture.project_id WHERE is_main=1 AND type_of_project=1");
        return $statement->fetchAll();
    }

    public function selectMainPictureProject2()
    {
        $statement = $this->pdo->query("SELECT * FROM $this->table JOIN " . self::TABLEPICTURE .
            " ON project.id=picture.project_id WHERE is_main=1 AND type_of_project=2");
        return $statement->fetchAll();
    }

    public function selectMainPictureProject3()
    {
        $statement = $this->pdo->query("SELECT * FROM $this->table JOIN " . self::TABLEPICTURE .
            " ON project.id=picture.project_id WHERE is_main=1 AND type_of_project=3");
        return $statement->fetchAll();
    }

    public function selectMainPictureProjectFavorite()
    {
        $statement = $this->pdo->query("SELECT * FROM $this->table JOIN " . self::TABLEPICTURE .
            " ON project.id=picture.project_id WHERE is_main=1 AND is_favorite=1");
        return $statement->fetchAll();
    }
}
