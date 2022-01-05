<?php

/**
 * Repository for DB communication surrounding classes
 */
class ClassRepository extends Repository
{

    /**
     * @param int $id
     * @return array|false
     */
    public function getClassesBySubjectId(int $id)
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM kaufmlu1.classes WHERE subjectId = :sid",
            [
                ":sid" => $id
            ]
        );
    }

    /**
     * @param int $id
     * @param int $type
     * @return array|false
     */
    public function getClassesBySubjectIdAndType(int $id, int $type)
    {
        return $this->dataLayer->selectAll(
            "SELECT c.id, c.dayOfWeek, c.timeOfDay, c.location, CONCAT(u.fname, ' ', u.lname) teacher
                    FROM kaufmlu1.classes c INNER JOIN users u ON c.teacher = u.id
                    WHERE subjectId = :sid AND type = :type
                    ORDER BY c.dayOfWeek",
            [
                ":sid" => $id,
                ":type" => $type
            ]
        );
    }


    /**
     * @param string $student
     * @param int $class
     * @return false|PDOStatement
     */
    public function signUpUserToClass(string $student, int $class)
    {
        $urepo = new UserRepository($this->dataLayer);
        return $this->dataLayer->insert(
            "INSERT INTO userstoclasses (user, class) VALUES (:user,:class)",
            [
                ":user" => $urepo->getUser($student)['id'],
                ":class" => $class
            ]
        );
    }

    /**
     * @param string $user
     * @return array|false
     */
    public function getUsersClasses(string $user)
    {
        return $this->dataLayer->selectAll(
            "SELECT c.id, c.dayOfWeek, c.timeOfDay, c.location, CONCAT(t.fname, ' ', t.lname) teacher  FROM kaufmlu1.userstoclasses utc
                    INNER JOIN users u on utc.user = u.id
                    INNER JOIN classes c on utc.class = c.id
                    INNER JOIN users t on c.teacher = t.id
                    WHERE u.uname = :user",
            [
                ":user" => $user
            ]
        );
    }

    /**
     *
     * @param string $user username of the user
     * @param int $class id of the class
     * @return bool
     */
    public function isUserAlreadySignedUp(string $user, int $class) :bool
    {
        $res = $this->dataLayer->selectOne(
            "SELECT * FROM userstoclasses utc
                    INNER JOIN users u on utc.user = u.id
                    WHERE u.uname = :uname
                    AND utc.class = :cid",
            [
                ":uname" => $user,
                ":cid" => $class
            ]
        );
        if (!$res) return $res;
        return true;
    }

    /**
     * @param string $student
     * @param int $class
     * @return false|PDOStatement
     */
    public function signOffUserFromClass(string $student, int $class)
    {
        $urepo = new UserRepository($this->dataLayer);
        return $this->dataLayer->delete(
            "DELETE FROM userstoclasses WHERE user = :user AND class = :class",
            [
                ":user" => $urepo->getUser($student)['id'],
                ":class" => $class
            ]
        );
    }

}