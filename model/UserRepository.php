<?php

/**
 * Repository for communicating with database over Users
 */
class UserRepository extends Repository
{
    /**
     * Function that creates a user in database
     * @param string $fname
     * @param string $lname
     * @param $dob
     * @param string $username
     * @param string $pass
     */
    public function createUser(string $fname, string $lname, $dob, string $username, string $pass) {
        $this->dataLayer->insert(
            "INSERT INTO users (fname,lname,dob,uname,pass)
                 VALUES (:fname,:lname,:dob,:uname,:pass)",
            [
                ":fname" => $fname,
                ":lname" => $lname,
                ":dob" => $dob,
                ":uname" => $username,
                ":pass" => $pass
            ]
        );

    }

    /**
     * Function that retrieves users hashed password from database
     * @param string $username Username of a user whose password should be retrieved
     * @return array|false
     */
    public function getUserPassword(string $username)
    {
        return $this->dataLayer->selectOne(
            "SELECT pass FROM users WHERE uname = :uname",
            [
                ":uname" => $username
            ]
        );
    }
}