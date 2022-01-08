<?php

/**
 * Abstract base class
 */
class Repository
{
    protected DataLayer $dataLayer;

    /**
     * Constructor to create a repository based class
     * @param DataLayer $db
     */
    public function __construct(DataLayer $db)
    {
        $this->dataLayer = $db;
    }

}