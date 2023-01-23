<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$delete = "UPDATE TASK SET JOINED = IF( JOINED = '0' , '1' , '0' ) WHERE ID = ".$_POST['id']." ; ";

if ( $mysql -> query ( $delete ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al cambiar a estado ingresado : " . $delete . "<br>" . $mysql->error;

}

?>