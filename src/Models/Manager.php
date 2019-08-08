<?php

    namespace App\Model;

USE PDO;

    abstract class Manager
{

    public function connectDTB()
    {
        require_once ('../../config/config.php');

        $dtb = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $dtb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}