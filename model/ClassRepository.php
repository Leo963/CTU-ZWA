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
                    ORDER BY c.dayOfWeek, c.timeOfDay",
            [
                ":sid" => $id,
                ":type" => $type
            ]
        );
    }


    /**
     * @param string $student username of the student to be signed up
     * @param int $class id of the class
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
     * @param string $user username
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
     * @param string $student username
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

    /**
     * Checks if there is someone signed up to given class
     * @param int $id Class id
     * @return bool
     */
    public function isAnyoneSignedUp(int $id) :bool
    {
        return $this->dataLayer->selectOne(
            "SELECT count(*) as count FROM userstoclasses WHERE class = :class",
            [
                ":class" => $id
            ]
        )['count'] > 0 ? true : false;
    }

    /**
     * @param int $class Class id
     */
    public function deleteClass(int $class)
    {
        $this->dataLayer->delete(
            "DELETE FROM classes WHERE id = :id",
            [
                ":id" => $class
            ]
        );
    }

    /**
     * @return array|false
     */
    public function getAllTypes()
    {
        return $this->dataLayer->selectAll("SELECT * FROM classtypes");
    }

    /**
     * Adds new class with specified parameters
     * @param int $type id of type as defined in classtypes table
     * @param int $teacher id of the user who is the teacher
     * @param string $timeOfDay time of day as a MariaSQL compatible time string (i.e. 110000 for 11:00:00)
     * @param int $dayOfWeek day of week as a number 1 - Monday thru 5 - Friday
     * @param string $location location of the class as string representation of locaiton code
     * @param int $subject id of the subject to which this class is associated to
     */
    public function addNewClass(int $type, int $teacher, string $timeOfDay, int $dayOfWeek, string $location, int $subject)
    {
        $this->dataLayer->insert(
            "INSERT INTO classes (subjectId, type, timeOfDay, dayOfWeek, location, teacher) 
                    VALUES (
                            :subject,
                            :type,
                            :timeOfDay,
                            :dayOfWeek,
                            :location,
                            :teacher
                    )",
            [
                ":subject" => $subject,
                ":type" => $type,
                ":timeOfDay" => $timeOfDay,
                ":dayOfWeek" => $dayOfWeek,
                ":location" => $location,
                ":teacher" => $teacher
            ]
        );
    }

}