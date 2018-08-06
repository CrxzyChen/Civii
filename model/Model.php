<?php
/**
 * Created by PhpStorm.
 * User: Crxzy
 * Date: 2018/8/5
 * Time: 23:08
 */

class Model
{
    private $_dbconfig;
    private $_conn;
    public function __construct()
    {
        $this->_dbconfig = $GLOBALS['config']->database;
        try {
            $this->_conn = new PDO($this->_dbconfig->dsn, $this->_dbconfig->user, $this->_dbconfig->password);
        } catch (PDOException $e) {
            var_dump($e);
        }
    }

    public function query($sql, $data)
    {
        $rows = [];
        try {
            $stmt = $this->_conn->prepare($sql);
            if ($stmt->execute($data)) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $rows[] = $row;
                }
            }
        } catch (PDOException $e) {
            var_dump($e);
        }
        return $rows;
    }
}