<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$update = " UPDATE task SET DESCRIPTION = '".$_POST['desc']."', TITLE = '".$_POST['title']."' WHERE ID = ".$_POST['id']." ";

if ( $mysql -> query ( $update ) === TRUE ) {

    $mysql -> close();

    echo 'OK';

} else {

    echo "Error al actualizar : " . $update . "<br>" . $mysql->error;

}

?>