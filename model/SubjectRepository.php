);
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
     * TODO
     * @param $id
     * @return array|false
     */
    public function getSubjectDetailsById(int $id)
    {
        return $this->dataLayer->selectOne(
            "SELECT * FROM subjectdetails WHERE id = :id",
            [
                ":id" => $id
            ]
        );
    }
}