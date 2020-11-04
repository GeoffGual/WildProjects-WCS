<?php


namespace App\Model;


class LangagueManager extends AbstractManager
{
    const TABLE = 'language';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
