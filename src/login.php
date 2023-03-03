<?php

session_start();

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$user = $_POST['user'];
$password = $_POST['password'];

$arrUsuario = array();
$arrLogin = array();

$selectUser = " SELECT 
                    `user`.`ID`
                FROM 
                    `user` 
                WHERE
                    `user`.`USER_NAME` = '{$user}' 
                ; ";

$result = $mysql -> query( $selectUser );

while( $row = $result -> fetch_assoc () ) {

    $arrUsuario['ID'] = $row['ID'];

}

if ( count ( $arrUsuario ) > 0 ) {

    $selectLogin = " SELECT 
                    `user`.`ID`,
                    `user`.`USER_NAME`
                FROM 
                    `user` 
                WHERE
                    `user`.`USER_NAME` = '{$user}' AND 
                    `user`.`PASSWORD` = '{$password}' 
                ; ";

    $result = $mysql -> query( $selectLogin );

    while( $row = $result -> fetch_assoc () ) {

        $arrLogin['ID'] = $row['ID'];
        $arrLogin['USER_NAME'] = $row['USER_NAME'];

    }

    if( count ( $arrLogin ) > 0 ){

        $_SESSION['ID_USER'] = $arrLogin['ID'];
        $_SESSION['USER_NAME'] = $arrLogin['USER_NAME'];

        echo 'OK';
        exit();

    }else{

        echo 'pass-incorrecta';
        exit();
    
    }
   
} else {

    echo 'user-incorrecto';
    exit();

}


?>