<?php

/**
 * Repository for communicating with database over Users
 */
class UserRepository extends Repository
{
    /**
     * Creates a user in database
     * @param string $fname First name
     * @param string $lname last name
     * @param string $dob Date of birth in format YYYY-MM-DD
     * @param string $username
     * @param string $pass password, to be provided as hashed, the result of password_hash() preffered
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
     * @param string $username username of the user whose password is to be updated
     * @param int $id id of the user whose password is to be updated
     * @param string $password new password, to be provided as hashed, the result of password_hash() preffered
     * @return bool true on success, false on failure
     */
    public function updatePassword(string $username, int $id, string $password) :bool {
        if (is_object($this->dataLayer->update(
            "UPDATE users 
                SET pass = :password
                WHERE id = :id AND uname = :uname",
            [
                ":password" => $password,
                ":id" => $id,
                ":uname" => $username
            ]
        ))) return true;
        return false;
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
     * Sets email of specified user
     * @param string $username username of the user whose email is to be set
     * @param string $email the email to be set
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
     * Fulltext username search accross all users
     * @param string $uname the username to be searched for
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
     * Fulltext username search accross users who have the role student
     * @param string $uname the username to be searched for
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
     * Fulltext name search accross users who have the role student
     * @param string $uname the fullname to be searched for
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
     * Fulltext name search accross users who have the role student
     * @param string $uname the fullname to be searched for
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
     * @param int $id id of the user to be retrieved
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
     * Sets the users first and last name
     * @param int $id id of the user to be updated
     * @param string $fname new first name
     * @param string $lname new last name
     * @return false|PDOStatement
     */
    public function updateUser(int $id, string $fname, string $lname)
    {
        return $this->dataLayer->update(
            "UPDATE users 
                    SET fname = :fname,
                    lname = :lname
                    WHERE id = :id",
            [
                ":fname" => $fname,
                ":lname" => $lname,
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

    /**
     * @return array|false
     */
    public function getRoles()
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM kaufmlu1.roles"
        );
    }


    /**
     * Checks if the user with the provided id is a teacher
     * @param int $teacher id the user to be checked
     * @return bool
     */
    public function isTeacher(int $teacher)
    {
        $role = $this->dataLayer->selectOne(
            "SELECT role FROM kaufmlu1.users WHERE id = :teacher",
            [
                ":teacher" => $teacher
            ]
        );
        if ($role[0] < 3) return true;
        return false;
    }


}