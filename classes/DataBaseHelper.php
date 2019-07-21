<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 17.07.2019
 * Time: 23:01
 */

namespace classes;

class DataBaseHelper
{
    private $db;
    public $num_rows;
    public $last_id;
    public $aff_rows;

    private $host = 'localhost';
    private $port = '5432';
    private $user = 'postgres';
    private $password = '';

    public $dbName = 'elevator';

    public function __construct()
    {
        $this->db = pg_connect("host=$this->host port=$this->port dbname=$this->dbName 
                                user=$this->user password=$this->password");
        if (!$this->db) {
            die("Ошибка соединения " . pg_last_error());
        };
    }

    public function close()
    {
        pg_close($this->db);
    }

    public function query($query)
    {
        $result_query = pg_query($this->db, $query) or die("Ошибка запроса" . pg_last_error());

        $this->close();
        return $result_query;
    }

    public function getRow($sql)
    {
        $result = pg_query($this->db, $sql);
        $row = pg_fetch_object($result);
        if (pg_last_error()) {
            exit(pg_last_error());
        }
        return $row;
    }

    public function getRows($sql)
    {
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) {
            exit(pg_last_error());
        }
        $this->num_rows = pg_num_rows($result);
        $rows = array();
        while ($item = pg_fetch_object($result)) {
            $rows[] = $item;
        }
        return $rows;
    }

    public function insert($sql, $id = 'id')
    {
        $sql .= ' RETURNING ' . $id;
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) {
            exit(pg_last_error());
        }
        $this->last_id = pg_fetch_result($result, 0);
        return $this->last_id;
    }

    public function exec($sql)
    {
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) {
            exit(pg_last_error());
        }
        $this->aff_rows = pg_affected_rows($result);
        return $this->aff_rows;
    }
}