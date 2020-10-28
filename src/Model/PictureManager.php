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
}
