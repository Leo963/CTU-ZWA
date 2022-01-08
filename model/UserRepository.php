<?php

/**
 * Repository for communicating with database over Users
 */
class UserRepository extends Repository
{
    /**
     * Creates a user in database
     * @param string $fname
     * @param string $lname
     * @param string $dob in format YYYY-MM-DD
     * @param string $username
     * @param string $pass
     */
    public function createUser(string $fname, string $lname, $dob, string $username, string $pass) {
        $this->dataLayer->insert(
            "INSERT INTO users (fname,lname,dob,uname,pass,role)
                 VALUES (:fname,:lname,:dob,:uname,:pass,4)",
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
     * Retrieves all information about the user
     * @param string $username Username of the user whose information you are retrieving
     * @return array|false
     */
    public function getUser(string $username) {
        return $this->dataLayer->selectOne(
            "SELECT * FROM users WHERE uname = :uname",
            [
                ":uname" => $username
            ]
        );
    }

    /**
     * Retrieves users hashed password from database
     * @param string $username Username of a user whose password should be retrieved
     * @return array|false
     */
    public function getUserPassword(string $username)
    {
        return $this->getUser($username)["pass"];
    }

    /**
     * Updates users password to a new one
     * @param string $username
     * @param int $id
     * @param string $password
     * @return false|PDOStatement False if update has failed
     */
    public function updatePassword(string $username, int $id, string $password) :bool {
        return $this->dataLayer->update(
            "UPDATE users 
                SET pass = :password
                WHERE id = :id AND uname = :uname",
            [
                ":password" => $password,
                ":id" => $id,
                ":uname" => $username
            ]
        );
    }

    /**
     * @return array|false
     */
    public function getAllUsers()
    {
        return $this->dataLayer->selectAll(
            "SELECT u.id, u.dob, u.uname username, CONCAT(u.fname, ' ', u.lname) fullname, r.name as role FROM users u
                    INNER JOIN roles r on u.role = r.id"
        );
    }

    /**
     * @return array|false
     */
    public function getAllStudents()
    {
        return $this->dataLayer->selectAll(
            "SELECT u.id, u.dob, u.uname username, CONCAT(u.fname, ' ', u.lname) fullname FROM users u
                    WHERE u.role = 3"
        );
    }

    /**
     * Adds email to specified user
     * @param string $username
     * @param string $email
     * @return false|PDOStatement
     */
    public function setEmail(string $username, string $email)
    {
        return $this->dataLayer->update(
            "UPDATE kaufmlu1.users SET email = :email WHERE uname = :uname",
            [
                ":email" => $email,
                ":uname" => $username
            ]
        );
    }

    /**
     * @param string $uname
     * @return array|false
     */
    public function getUsersUsernameSearch(string $uname)
    {
        return $this->dataLayer->selectAll(
            "SELECT u.id, u.dob, u.uname username, CONCAT(u.fname, ' ', u.lname) fullname, r.name as role FROM users u
                    INNER JOIN roles r on u.role = r.id
                    WHERE u.uname LIKE (:uname)",
            [
                ":uname" => "%".$uname."%"
            ]
        );
    }

    /**
     * @param string $uname
     * @return array|false
     */
    public function getStudentsUsernameSearch(string $uname)
    {
        return $this->dataLayer->selectAll(
        "SELECT u.id, u.dob, u.uname username, CONCAT(u.fname, ' ', u.lname) fullname FROM users u
                    WHERE u.role = 3
                    AND u.uname LIKE (:uname)",
            [
                ":uname" => "%".$uname."%"
            ]
        );
    }

    /**
     * @param string $uname
     * @return array|false
     */
    public function getUsersFullnameSearch(string $uname)
    {
        return $this->dataLayer->selectAll(
            "SELECT u.id, u.dob, u.uname username, CONCAT(u.fname, ' ', u.lname) fullname, r.name as role FROM users u
                    INNER JOIN roles r on u.role = r.id
                    WHERE CONCAT(u.fname, ' ', u.lname) LIKE (:uname)
                    OR u.fname LIKE (:uname)
                    OR u.lname LIKE (:uname)",
            [
                ":uname" => "%".$uname."%"
            ]
        );
    }

    /**
     * @param string $uname
     * @return array|false
     */
    public function getStudentsFullnameSearch(string $uname)
    {
        return $this->dataLayer->selectAll(
            "SELECT u.id, u.dob, u.uname username, CONCAT(u.fname, ' ', u.lname) fullname FROM users u
                    WHERE u.role = 3
                    AND CONCAT(u.fname, ' ', u.lname) LIKE (:uname)
                    OR u.fname LIKE (:uname)
                    OR u.lname LIKE (:uname)",
            [
                ":uname" => "%".$uname."%"
            ]
        );
    }

    /**
     * @param int $id
     * @return array|false
     */
    public function getUserById(int $id)
    {
        return $this->dataLayer->selectOne(
            "SELECT * FROM users WHERE id = :id",
            [
                ":id" => $id
            ]
        );
    }

    /**
     * @param int $id
     * @param string $username
     * @param string $fname
     * @param string $lname
     * @param $dob
     * @return false|PDOStatement
     */
    public function updateUser(int $id, string $username, string $fname, string $lname, $dob)
    {
        return $this->dataLayer->update(
            "UPDATE users 
                    SET uname = :uname,
                    fname = :fname,
                    lname = :lname,
                    dob = :dob
                    WHERE id = :id",
            [
                ":uname" => $username,
                ":fname" => $fname,
                ":lname" => $lname,
                ":dob" => $dob,
                ":id" => $id
            ]
        );
    }

    /**
     * @return array|false
     */
    public function getAllTeachers()
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM users WHERE role < 3"
        );
    }


}