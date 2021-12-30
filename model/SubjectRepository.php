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
    function getAllSubjects() {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects"
        );
    }

    /**
     * Gets subjects for pagination
     * @param int $offset Offset of the entries, default 0
     * @param int $limit Limit of the number of elements per page, default 5
     */
    function getPaginatedSubjects(int $offset = 0, int $limit = 5) {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects LIMIT $limit OFFSET $offset"
        );
    }

    /**
     * Gets subjects for pagination, ordered alphabetically
     * @param int $offset Offset of the entries, default 0
     * @param int $limit Limit of the number of elements per page, default 5
     */
    function getPaginatedSubjectsAlphabet(int $offset = 0, int $limit = 5) {
        return $this->dataLayer->selectAll(
            "SELECT * FROM subjects ORDER BY name LIMIT $limit OFFSET $offset"
        );
    }

    /**
     * @return false|int returns false when there is an error and the count of subjects if all is right
     */
    function countSubjects() {
        $result = $this->dataLayer->selectOne(
            "SELECT COUNT(*) FROM subjects"
        );
        return $result ? (int)$result[0] : false;
    }
}