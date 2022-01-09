<?php

/**
 * Class with constants used in multiple files to reduce code duplication
 */
class Helper
{

    /**
     * ID of lecture as defined in classtypes table
     */
    const LECTURE = 1;
    /**
     * ID of practical as defined in classtypes table
     */
    const PRACTICAL = 2;
    /**
     * ID of lab as defined in classtypes table
     */
    const LAB = 3;
    /**
     * A string used to add the length of class to its start time
     */
    const CLASSLENGTH = "+1 hour +30 minutes";
}