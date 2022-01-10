<?php

namespace Service;

trait DatabaseTrait
{
    protected static $mysqlConnection;

    public static function connect()
    {
        require "config.php";

        if (empty($databaseName) || empty($databaseUserName) || empty($databasePassword) || empty($databaseHost) || empty($databasePort)) {
            throw new \Exception("Please configure your config.php");
        }

        if (empty(static::$mysqlConnection)) {
            static::$mysqlConnection = new \mysqli($databaseHost, $databaseUserName, $databasePassword, $databaseName) or die(mysqli_error(static::$mysqlConnection));
        }

        return static::$mysqlConnection;
    }

}
