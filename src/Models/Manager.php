<?php

namespace App\Model;

use PDO;

abstract class Manager
{

    static protected $dtb = null;

    public function connectDB()
    {
        require_once ('../config/config.php');

        if ((self::$dtb) === null) {
            $dtb = new PDO('mysql:host=' . HOST_NAME . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PWD);
            $dtb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$dtb = $dtb;
        }
        return self::$dtb;
    }
}