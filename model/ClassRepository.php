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
    public function getClassesBySubjectId(int $id) {
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
    public function getClassesBySubjectIdAndType(int $id, int $type) {
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

}