<?php

namespace App\DatabaseAdapters;

class MySQLAdapter
{
    /**
     * @var resource
     */
    public static $instance;

    /**
     * @return resource
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $env = json_decode(file_get_contents(".env"), true);
            self::$instance = new \PDO(
                "mysql:dbname=" . $env["DATABASE"] . ";host=" . $env["HOST"],
                $env["USER"],
                $env["PASSWORD"]
            );
        }

        return self::$instance;
    }
}
