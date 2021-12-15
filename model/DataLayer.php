<?php

require_once("Config.php");

/**
 * Database connection layer
 */

class DataLayer
{
    protected PDO $conn;

    /**
     * Constructor creating PDO connection and set collation to UTF-8
     */
    public function __construct()
    {
        $this->conn = new PDO('mysql:host=' . Config::HOSTNAME . ';dbname=' . Config::DBNAME,
            Config::USERNAME,
            Config::PASSWORD);
        $this->conn->query('SET NAMES utf8');
    }

    /**
     * Function to execute SQL query with given parameters
     * @param string $sql SQL query in the form of a string, parameters to be passed as an array in second param
     * @param array $PARAMS Parameters for the SQL query in the form of a dictionary array
     * @return false|PDOStatement
     */
    public function exec(string $sql, array $PARAMS = [])
    {
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute($PARAMS);
        if ($result === false) {
            var_dump($stmt->errorInfo());
        }
        return $stmt;
    }

    /**
     * Function to select all results
     * @param string $sql SQL query in the form of a string, parameters to be passed as an array in second param
     * @param array $params Parameters for the SQL query in the form of a dictionary array
     * @return array|false
     */
    public function selectAll(string $sql,array $params = [])
    {
        return $this->exec($sql, $params)->fetchAll();
    }

    /**
     * Function to select the first result
     * @param string $sql SQL query in the form of a string, parameters to be passed as an array in second param
     * @param array $params Parameters for the SQL query in the form of a dictionary array
     * @return array|false
     */
    public function selectOne(string $sql, array $params = [])
    {
        return $this->exec($sql, $params)->fetch();
    }

    /**
     * Function to execute an insert query
     * @param string $sql SQL query in the form of a string, parameters to be passed as an array in second param
     * @param array $params Parameters for the SQL query in the form of a dictionary array
     * @return PDOStatement|false
     */
    public function insert(string $sql, array $params = [])
    {
        return $this->exec($sql, $params);
    }

    /**
     * Function to execute an insert query and return ID of the last inserted row
     * @param string $sql SQL query in the form of a string, parameters to be passed as an array in second param
     * @param array $params Parameters for the SQL query in the form of a dictionary array
     * @return string ID of the last inserted row
     */
    public function insertID(string $sql, array $params = []) :string
    {
        $this->exec($sql, $params);
        return $this->conn->lastInsertId();
    }

    /**
     * Function that executes a DELETE SQL query
     * @param string $sql SQL query in the form of a string, parameters to be passed as an array in second param
     * @param array $params
     * @return false|PDOStatement
     */
    public function delete (string $sql, array $params)
    {
        return $this->exec($sql,$params);
    }

    /**
     * Function that executes an UPDATE SQL query
     * @param string $sql SQL query in the form of a string, parameters to be passed as an array in second param
     * @param array $params
     * @return false|PDOStatement
     */
    public function update (string $sql, array $params)
    {
        return $this->exec($sql,$params);
    }
}