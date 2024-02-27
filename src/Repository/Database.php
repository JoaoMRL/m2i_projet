<?php
namespace App\Repository;

class Database {
    public static function getCo(){
        return new \PDO('mysql:host=localhost;dbname=app_partage_perso','root','');
    }
}