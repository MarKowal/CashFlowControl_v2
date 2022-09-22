<?php
    session_start();
    
    if((!isset($_POST['login'])) || (!isset($_POST['password']))){
        header('Location: index.php');
        exit();
    }

    $host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "cashflowcontrol";
?>