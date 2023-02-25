<?php

session_start();

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$delete = "UPDATE TASK SET JOINED = IF( JOINED = '0' , '1' , '0' ) WHERE ID = ".$_POST['id']." AND USER_ID = ".$_SESSION['ID_USER']." ; ";

if ( $mysql -> query ( $delete ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al cambiar a estado ingresado : " . $delete . "<br>" . $mysql->error;

}

?>