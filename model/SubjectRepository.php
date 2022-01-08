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
     * TODO
     * @param $id int Id of the subject to retrieve
     * @return array|false
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
     * Gets
     * @param $id
     * @return array|false
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
     * @return array|false
     */
    public function getAllSubjectsWithDetails()
    {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects s INNER JOIN subjectdetails s2 on s.id = s2.id ORDER BY s.code"
        );
    }

    /**
     * @param string $code
     * @return array|false
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
     * @param string $name
     * @return array|false
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
     * @param int $id
     * @param string $anotation
     * @param string $description
     * @param int $length
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
     * @param string $code
     * @param string $name
     * @return string
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