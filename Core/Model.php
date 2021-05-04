<?php

namespace Core;

use Exception;
use Model\User;
use PDO;
use PDOException;

class Model
{
    private static $dbInfo = null;
    private static $PDOInstance = null;
    protected $tableName = '';
    protected $primaryKey = 'id';

    public function __construct()
    {
        self::$dbInfo = include('Config/database.php');
        if (!self::$PDOInstance) {
            try {
                self::$PDOInstance = new PDO('mysql:host=' . self::$dbInfo['host'] . ';dbname=' . self::$dbInfo['database'], self::$dbInfo['username'], self::$dbInfo['password']);
            } catch (PDOException $e) {
                throw new Exception($e->getMessage());
            }
        }
    }


    public static function find(int $id) : Model
    {
        $model = new static;
        $sth = self::$PDOInstance->prepare("SELECT * FROM " . $model->tableName . " where " . $model->primaryKey . " = $id");
        $sth->execute();
        $keys = $sth->fetch();


        foreach ($keys as $key => $value) {
            if (!is_numeric($key)) {
                $model->$key = $value;
            }
        }

        return $model;
    }

    public static function update(array $collection, array|int $whereCollection = null) : bool
    {
        $model = new static;

        $initializedWhereCollection = array();
        foreach ($whereCollection as $key => $value) {
            $initializedWhereCollection[] = "$key = $value";
        }
        $whereString = implode(" AND ", $initializedWhereCollection);

        $initializedCollection = array();
        foreach ($collection as $key => $value) {
            $initializedCollection[] = "$key = " . ((is_string($value) and !strstr($value, 'operator:')) ? "'" . $value ."'" : str_replace('operator:', '', $value));
        }


        try {
            $sth = self::$PDOInstance->prepare("UPDATE " . $model->tableName . " SET ".implode(" , ", $initializedCollection)." WHERE ".$whereString);
            $result = $sth->execute();
            if ($result) { return true; }
            else { return false; }
        }
        catch( PDOException $Exception ) {
//            throw new Exception($Exception->getMessage());
            return false;
        }
    }

    public static function create(array $collection) : bool
    {
        $model = new static;

        $initializedCollection = array();
        foreach ($collection as $key => $value) {
            $initializedCollection[] = "$key = " . ((is_string($value) and !strstr($value, 'operator:')) ? "'" . $value ."'" : str_replace('operator:', '', $value));
        }

        try {
            $sth = self::$PDOInstance->prepare("INSERT INTO " . $model->tableName . " SET " . implode(" , ", $initializedCollection));
            $result = $sth->execute();
            if ($result) { return true; }
            else { return false; }
        }
        catch( PDOException $Exception ) {
//            throw new Exception($Exception->getMessage());
            return false;
        }

    }
}