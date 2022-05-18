<?php

namespace App\Services;

use App\Config\Database;
use Exception;

class QueryHandler
{
    protected $database;
    protected $tableName;
    protected $fields; //[field1, field2, ...]
    protected $data; //[value1, value2, ...]
    protected $where = array(); //Usage: array([column, condition, value], ...)
    protected $join = array(); //Usage: array([Join Type, table2, table1.field, table2.field], ...)
    protected $orderBy = array(); //Usage: [Field, ASC/DESC];
    protected $to_delete = array();

    public function __construct()
    {
        $this->database = new Database();
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    //Get data from the database and return it
    public function get($num_data)
    {
        if (empty($this->fields)) {
            return;
        }

        $fields = implode(',', $this->fields);
        $join = $this->handleJoinClause();
        $where = $this->handleWhereClause();
        $orderBy = $this->handleOrderBy();

        $statement = "SELECT $fields FROM $this->tableName $join $where $orderBy";

        //return $statement;

        try {
            $result = array();
            $query = $this->database->db()->query($statement);

            if ($num_data == 'first') {
                if ($query->num_rows <= 0) {
                    return false;
                }

                return $query->fetch_assoc();
            }

            while ($row = $query->fetch_assoc()) {
                $result[] = $row;
            }

            return $result;
        } catch (Exception $e) {
            //die($e->getMessage());
            return false;
        }
    }

    //Inserts data in to the database and returns the inserted ID
    public function insert()
    {
        $fields = implode(',', $this->fields);
        $data = implode("','", $this->data);

        $statement = "INSERT INTO $this->tableName ($fields) VALUES ('$data')";

        try {
            $db = $this->database->db();
            $query = $db->query($statement);
            $this->database->close();

            return $db->insert_id;
        } catch (Exception $e) {
            return false;
        }
    }

    //Delete query handler
    public function delete()
    {
        $listIds = implode(',', $this->to_delete);

        try {
            $statement = "DELETE FROM $this->tableName where id IN ($listIds)";
            $this->database->db()->query($statement);

            $this->database->close();

            return $this->to_delete;
        } catch (Exception $e) {
            return false;
        }
    }

    //Handling where clause in MYSQL Query
    public function handleWhereClause()
    {
        $where = '';
        $i = 0;

        if (count($this->where) > 0) {
            $where = 'WHERE ';

            foreach ($this->where as $whereClause) {
                if (count($whereClause) !== 3) {
                    return;
                }

                $whereClause[2] = "'" . $whereClause[2] . "'";

                $where = $where . implode(' ', $whereClause) . ($i !== count($this->where) - 1 ? ' AND ' : '');

                $i++;
            }
        }


        return $where;
    }

    //Handling JOIN Clase in MYSQL Query
    public function handleJoinClause()
    {
        $join = '';
        $i = 0;

        if (count($this->join) > 0) {
            foreach ($this->join as $joinClause) {

                if (count($joinClause) !== 4) {
                    return;
                }

                //Adding ON to the query
                array_splice($joinClause, 2, 0, 'ON');

                //Adding Equal sign to the query
                array_splice($joinClause, 4, 0, '=');

                //Implode array
                $join = $join . implode(' ', $joinClause) . ' ';

                $i++;
            }
        }


        return $join;
    }

    //Handling Order By Clause in MYSQL Query
    public function handleOrderBy()
    {
        $orderBy = '';
        if (count($this->orderBy) > 0 && count($this->orderBy) == 2) {
            $orderBy = 'ORDER BY ' . implode(' ', $this->orderBy);
        }

        return $orderBy;
    }
}
