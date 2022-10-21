<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$delete = "DELETE FROM task WHERE ID = ".$_POST['id']."";

if ( $mysql -> query ( $delete ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al eliminar : " . $delete . "<br>" . $mysql->error;

}

?>