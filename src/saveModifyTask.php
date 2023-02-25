<?php

session_start();

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$update = " UPDATE task SET DESCRIPTION = '".$_POST['desc']."', TITLE = '".$_POST['title']."' WHERE ID = ".$_POST['id']." AND USER_ID = ".$_SESSION['ID_USER']." ";

if ( $mysql -> query ( $update ) === TRUE ) {

    $mysql -> close();

    echo 'OK';

} else {

    echo "Error al actualizar : " . $update . "<br>" . $mysql->error;

}

?>