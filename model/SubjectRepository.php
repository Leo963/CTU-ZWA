<?php

/**
 * Repository for database interaction over Subjects
 */
class SubjectRepository extends Repository
{
    /**
     * Returns all subjects in the database
     * @return array|false
     */
    function getAllSubjects()
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects"
        );
    }

    /**
     * Gets subjects for pagination
     * @param int $offset Offset of the entries, default 0
     * @param int $limit Limit of the number of elements per page, default 5
     */
    function getPaginatedSubjects(int $offset = 0, int $limit = 5)
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects LIMIT $limit OFFSET $offset"
        );
    }

    /**
     * Gets subjects for pagination, ordered alphabetically
     * @param array $dir
     * @param array $orderby
     * @param int $offset Offset of the entries, default 0
     * @param int $limit Limit of the number of elements per page, default 5
     */
    function getPaginatedSubjectsOrdered(array $dir = [], array $orderby = [], int $offset = 0, int $limit = 5)
    {
        if (empty($orderby)) {
            return $this->dataLayer->selectAll(
                "SELECT * FROM subjects ORDER BY name LIMIT $limit OFFSET $offset"
            );
        } else {
            $query = "SELECT * FROM subjects ORDER BY ";
            for ($i = 0; $i < count($orderby); $i++) {
                if ($i == count($orderby) - 1) {
                    $query .= $orderby[$i] . " " . $dir[$i] . " ";
                } else {
                    $query .= $orderby[$i] . " " . $dir[$i] . ", ";
                }

            }
            $query .= "LIMIT $limit OFFSET $offset";
            return $this->dataLayer->selectAll(
                $query
            );
        }
    }

    /**
     * @return false|int returns false when there is an error and the count of subjects if all is right
     */
    function countSubjects()
    {
        $result = $this->dataLayer->selectOne(
            "SELECT COUNT(*) FROM subjects"
        );
        return $result ? (int)$result[0] : false;
    }

    /**
     * @param $id int Id of the subject to retrieve
     * @return array|false array on success, false on failure
     */
    public function getSubjectByid(int $id)
    {
        return $this->dataLayer->selectOne(
            "SELECT * FROM subjects WHERE id = :id",
            [
                ":id" => $id
            ]
        );
    }

    /**
     * @param int $id ID of the subject
     * @return array|false array on success, false on failure
     */
    public function getSubjectDetailsById(int $id)
    {
        return $this->dataLayer->selectOne(
            "SELECT * FROM subjectdetails sd INNER JOIN subjects s on sd.id = s.id WHERE s.id = :id",
            [
                ":id" => $id
            ]
        );
    }

    /**
     * @return array|false array on success, false on failure
     */
    public function getAllSubjectsWithDetails()
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects s INNER JOIN subjectdetails s2 on s.id = s2.id ORDER BY s.code"
        );
    }

    /**
     * @param string $code Fulltext code search
     * @return array|false array on success, false on failure
     */
    public function getSubjectsCodeSearch(string $code)
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects s INNER JOIN subjectdetails s2 on s.id = s2.id
                    WHERE s.code LIKE (:code)
                    ORDER BY s.code",
            [
                ":code" => "%" . $code . "%"
            ]
        );
    }

    /**
     * @param string $name Fulltext name search
     * @return array|false array on success, false on failure
     */
    public function getSubjectsNameSearch(string $name)
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects s INNER JOIN subjectdetails s2 on s.id = s2.id
                    WHERE s.name LIKE (:name)
                    ORDER BY s.code",
            [
                ":name" => "%" . $name . "%"
            ]
        );
    }

    /**
     * Sets the detail values of existing subject to the provided values
     * @param int $id ID of the subject
     * @param string $anotation the anotation of the subject
     * @param string $description the description of the subject
     * @param int $length length in weeks of the subject, should be between 1 and 42 inclusive
     */
    public function updateDetails(int $id, string $anotation, string $description, int $length)
    {
        $this->dataLayer->update(
            "UPDATE subjectdetails
                    SET anotation = :anotation,
                    description = :description,
                    length = :length
                    WHERE id = :id",
            [
                ":id" => $id,
                ":anotation" => $anotation,
                ":description" => $description,
                ":length" => $length
            ]
        );
    }

    /**
     * Creates a new subject from the given values
     * @param string $code Subject code
     * @param string $name Subject name
     * @return string ID of the inserted row
     */
    public function newSubject(string $code, string $name)
    {
        return $this->dataLayer->insertID(
            "INSERT INTO subjects (name, code) 
                    VALUES (:name, :code)",
            [
                ":name" => $name,
                ":code" => $code
            ]
        );
    }
}