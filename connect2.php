<?php
    define("DBHOST", "mysql-noobnotes.alwaysdata.net");
    define("DBUSER", "noobnotes");
    define("DBPASS", "JPZA_2MD4VX:i-4");
    define("DBNAME", "noobnotes_db");

    $dsn = "mysql:dbname=".DBNAME.";host=".DBHOST;

    try{
        $db = new PDO($dsn, DBUSER, DBPASS);
        $db ->exec("SET NAMES utf8");
    }catch(PDOException $e){
        die("Erreur:".$e->getMessage());
    }
?>