<?php
require_once('../config/loader.php');
try{
    $hasLogin = $_SESSION['login'];
    if($hasLogin){
        unset($_SESSION['username']);
        unset($_SESSION['mobile']);
        unset($_SESSION['email']);
        unset($_SESSION['role']);
        unset($_SESSION['login']);

        header('Location: ../index.php?logout=ok');
    }else{
        header('Location: ../index.php');
    }
}catch(PDOEception $e){
    echo "Your error message is : " . $e->getMessage();
}