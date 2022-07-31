<?php
    $db     = "mysql:host=localhost;dbname=gallery";
    $dbUser ='root';
    $dbPass ='';

    try{
        $conn = new PDO($db,$dbUser,$dbPass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected!!";
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>