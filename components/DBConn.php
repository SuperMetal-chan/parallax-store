<?php


class DBConn
{

    public static function getConnection()
    {
        $dbParametersPath = ROOT.'/configuration/db.php';
        $dbParameters = include($dbParametersPath);
        /** @var TYPE_NAME $ */
        $dsn = "mysql:host={$dbParameters["host"]};dbname={$dbParameters["dbname"]}";
        $conn = new PDO($dsn, $dbParameters["user"], $dbParameters["password"]);
        return $conn;
    }


}