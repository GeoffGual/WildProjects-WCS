<?php


namespace App\Model;


class ProjectManager extends AbstractManager
{
    const TABLE = 'project';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
