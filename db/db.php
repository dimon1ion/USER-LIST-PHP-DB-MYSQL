<?php

    function dbConnect($config){
        
        $conn = mysqli_connect($config["host"], $config["username"], $config["password"], $config["dbname"]);

        if ($conn == false){
            return print("Произошла огибка при выполнеии запроса!".mysqli_connect_error());
        } else {
            return $conn;
        }
        
    }

    function errorMessage($config, $result){
        if ($result === false) {
            return print("Произошла ошибка при выполнении запроса!" . mysqli_error(dbConnect($config)));
        }
    }

?>